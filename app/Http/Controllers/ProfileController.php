<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment_History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        return view('profile.change-pass', [
            'title' => 'Đổi mật khẩu'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp',
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
        if ($status !== null) {
            // Kiểm tra nếu status là một giá trị hợp lệ, ví dụ: 1, 2, 3, 4
            $orders = Order::where('user_id', Auth::user()->id)
                ->where('status', $status)
                ->get();
        } else {
            // Nếu không có status, lấy tất cả đơn hàng của người dùng
            $orders = Order::where('user_id', Auth::user()->id)->where('status', '!=', Order::PAYMENT_STATUS_PENDING)->get();
        }

        // Trả về kết quả dưới dạng JSON hoặc view tùy theo nhu cầu
        return view('profile.order', compact('orders'), [
            'title' => 'Đơn hàng của bạn'
        ]);
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            // Kiểm tra quyền hủy: chỉ chủ đơn mới được hủy, và chỉ khi đang "chờ duyệt"
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Bạn không có quyền hủy đơn này.');
            }

            if ($order->status != 0) {
                return redirect()->back()->with('error', 'Chỉ đơn hàng chờ duyệt mới được hủy.');
            }

            // Hoàn tiền
            $user = $order->user;
            $user->money += $order->total_amount;
            $user->save();

            // Cập nhật trạng thái đơn
            $order->status = 2; // 2 = đã hủy
            $order->rejection_reason = 'Người dùng hủy đơn'; // tuỳ bạn ghi lý do
            $order->save();

            DB::commit();

            return redirect()->back()->with('success', 'Đã hủy đơn hàng và hoàn tiền thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Nạp tiền vào tài khoản
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000',
        ]);

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('payment.deposit.complete');
        $vnp_TmnCode = "OKGS5CXM";
        $vnp_HashSecret = "248XXFTLPU48PYC1UDQT41TXA2LPV3SV";

        $vnp_TxnRef = 'TOPUP' . Auth::id() . time();
        $vnp_OrderInfo = "Nạp tiền vào tài khoản";
        $vnp_OrderType = 'topup';
        $vnp_Amount = (int)$request->amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        // Sắp xếp theo key tăng dần
        ksort($inputData);
        $hashdata = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            $hashdata .= ($i++ ? '&' : '') . urlencode($key) . '=' . urlencode($value);
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '?' . $query . 'vnp_SecureHash=' . $vnpSecureHash;

        Payment_History::create([
            'order_code' => 0,
            'user_id' => Auth::id(),
            'amount_money' => $request->amount,
            'payment_status' => 0,
            'TransactionStatus' => 'pending',
            'TransactionNo' => $vnp_TxnRef
        ]);

        return redirect($vnp_Url);
    }

    // Nạp tiền hoàn tất
    public function depositComplete(Request $request)
    {
        $vnp_ResponseCode = $request->query('vnp_ResponseCode');
        $vnp_Amount = (int) $request->query('vnp_Amount') / 100;
        $vnp_TxnRef = $request->query('vnp_TxnRef');

        $payment = Payment_History::where('TransactionNo', $vnp_TxnRef)->first();

        if ($vnp_ResponseCode === '00') {
            // Cập nhật status
            $payment->update([
                'payment_status' => 1,
                'TransactionStatus' => 'success',
                'vnp_BankTranNo' => $request->query('vnp_BankTranNo'),
                'vnp_ResponseCode' => $vnp_ResponseCode,
                'BankCode' => $request->query('vnp_BankCode')
            ]);

            // Cộng tiền vào tài khoản user
            $user = $payment->user;
            $user->money += $payment->amount_money;
            $user->save();

            return redirect()->route('profile.payment_history')->with('success', 'Nạp tiền thành công!');
        } else {
            $payment?->update([
                'payment_status' => 0,
                'TransactionStatus' => 'failed',
                'vnp_ResponseCode' => $vnp_ResponseCode,
                'BankCode' => $request->query('vnp_BankCode')
            ]);

            return redirect()->route('profile.payment_history')->with('error', 'Nạp tiền thất bại!');
        }
    }

    // Lịch sử nạp tiền
    public function depositHistory()
    {
        $histories = Payment_History::where('user_id', Auth::id())->where('order_code',0)->orderBy('created_at', 'desc')->get();

        return view('profile.payment_history', compact('histories'), [
            'title' => 'Lịch sử nạp tiền'
        ]);
    }
}
