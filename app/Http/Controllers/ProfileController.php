<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'), ['title' => 'Trang cá nhân']);
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name  = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;

        // Xử lý upload ảnh
        if ($request->hasFile('avatar')) {
            // Xoá ảnh cũ nếu tồn tại
            $oldPath = public_path('images/avatars/' . $user->avatar);
            if ($user->avatar && file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Đặt tên file mới dựa theo slug của tên người dùng
            $filename = Str::slug($user->name) . '.' . $request->file('avatar')->getClientOriginalExtension();

            // Di chuyển ảnh đến thư mục public/images/avatars
            $request->file('avatar')->move(public_path('images/avatars'), $filename);

            // Gán tên file vào user
            $user->avatar = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changePasswordForm()
    {
        return view('profile.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công.');
    }

    public function orders(Request $request)
    {
        // Lấy status từ request, nếu không có thì mặc định là tất cả trạng thái
        $status = $request->status;
    
        // Nếu có status, lọc theo status
        if ($status) {
            // Kiểm tra nếu status là một giá trị hợp lệ, ví dụ: 1, 2, 3, 4
            $orders = Order::where('user_id', Auth::user()->id)
                           ->where('status', $status)
                           ->get();
        } else {
            // Nếu không có status, lấy tất cả đơn hàng của người dùng
            $orders = Order::where('user_id', Auth::user()->id)->where('status','!=', Order::PAYMENT_STATUS_PENDING)->get();
        }
    
        // Trả về kết quả dưới dạng JSON hoặc view tùy theo nhu cầu
        return view('profile.order', compact('orders'),[
            'title' => 'Đơn hàng của bạn'
        ]);
    }
}
