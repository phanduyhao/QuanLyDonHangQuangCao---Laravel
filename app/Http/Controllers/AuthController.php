<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AuthController extends Controller
{
    use ValidatesRequests;

    public function showRegister(){
        return view('auth.register',[
            'title' => 'Đăng ký tài khoản',
        ]);
    }

    /**
     * Đăng ký tài khoản.
     * @param Request $request
     */
    public function register(Request $request)
    {
       // Validate the request
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password',
        ], [
            'name.required' => 'Vui lòng nhập tên của bạn!',
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Email không hợp lệ!',
            'email.unique' => 'Email đã tồn tại!',
            'phone.required' => 'Vui lòng nhập số điện thoại!',
            'phone.unique' => 'Số điện thoại đã tồn tại!',
            'password.required' => 'Vui lòng nhập mật khẩu!',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự!',
            'confirmPassword.required' => 'Vui lòng xác nhận mật khẩu!',
            'confirmPassword.same' => 'Mật khẩu xác nhận không khớp!',

        ]);
        $confirmPass = $request->confirmPassword;
        $pass = $request->password;
        if ($confirmPass == $pass) {
            // Kiểm tra xem email đã tồn tại chưa
            $emailExists = User::where('email', $request->email)->exists();

            if (!$emailExists) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = bcrypt($request->password);
                $user->save();
                Auth::login($user);
            } else {
                return back()->with('error', 'Email đã tồn tại');
            }
        } else {
            return back()->with('error', 'Xác nhận lại mật khẩu !');
        }
        return redirect('/'); // Điều hướng sau khi đăng ký
    }


    public function showLogin(){
        return view('auth.login',[
            'title' => 'Đăng nhập'
        ]);
    }

    /**
     * Đăng nhập.
     * @param Request $request
     */

    public function login(Request $request)
    {
        // Validate đầu vào
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Vui lòng nhập email',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Xác định kiểu login
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (preg_match('/^[0-9]{9,15}$/', $login)) {
            $fieldType = 'phone'; // Đảm bảo cột 'phone' tồn tại trong DB
        } else {
            return back()->withErrors([
                'login' => 'Thông tin đăng nhập không hợp lệ. Vui lòng dùng email hoặc số điện thoại.',
            ])->withInput($request->only('login'));
        }


        // Kiểm tra xem tài khoản có tồn tại không
        $user = User::where($fieldType, $login)->first();
        if (!$user) {
            return back()->withErrors([
                'login' => 'Tài khoản không tồn tại',
            ])->withInput($request->only('login'));
        }

        // Thử đăng nhập
        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công');
        }

        // Mật khẩu sai
        return back()->withErrors([
            'login' => 'Sai mật khẩu',
        ])->withInput($request->only('login'));
    }



     public function showForgotPass(){
         return view('auth.forgotPass',[
             'title' => 'Quên mật khẩu'
         ]);
     }

     public function sendMailForgotPass(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ],[
            'email.required' => 'Vui lòng nhập email !',
            'email.exists' => 'Email không tồn tại !',
        ]);

        $token = Str::random(64);

        // Lưu token vào bảng password_resets
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Gửi email
        Mail::send('auth.emailResetPassword', ['token' => $token], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu');
        });

        return back()->with('success', 'Email đặt lại mật khẩu đã được gửi.');
    }

    public function showResetPassword($token) {
        return view('auth.resetPassword', ['token' => $token, 'title' => 'Tạo mật khẩu mới']);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        // Tìm email từ token
        $reset = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$reset) {
            return back()->withErrors(['token' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }

        // Cập nhật mật khẩu
        $user = \App\Models\User::where('email', $reset->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        // Xóa token sau khi sử dụng
        DB::table('password_resets')->where(['email' => $reset->email])->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu của bạn đã được đặt lại thành công.');
    }


    /**
     * Đăng xuất.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLogin');
    }
}
