<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ServicePricing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'package_id' => 'required|exists:service_pricings,id',
            'campaign_name' => 'nullable|string|max:255',
            'reach_total' => 'nullable',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Tính số ngày chạy quảng cáo
        $start = Carbon::parse($validated['start_date']);
        $end = Carbon::parse($validated['end_date']);
        $days = $start->diffInDays($end) + 1;

        // Lấy gói quảng cáo
        $package = ServicePricing::findOrFail($validated['package_id']);

        // Tính tổng chi phí
        $totalAmount = $days * $package->price;
        // Tạo đơn hàng
        $order = Order::create([
            'order_code' => strtoupper(Str::random(8)),
            'user_id' => Auth::id(),
            'service_pricing_id' => $validated['package_id'],
            'campaign_name' => $validated['campaign_name'],
            'campaign_content' => $validated['content'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'number_of_days' => $days,
            'total_amount' => $totalAmount,
            'reach_total' => $validated['reach_total'],
            'status' => null, // 0: pending, 1: paid, 2: rejected (ví dụ)
            'rejection_reason' => null,
        ]);

        return redirect()->route('orders.checkout')->with('success', 'Đơn hàng đã được tạo');
    }


    public function checkout()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('status', Order::PAYMENT_STATUS_PENDING)->get();

        return view('order.checkout', compact('orders'),[
            'title' => 'Thanh toán đơn hàng',
        ]);
    }

    public function destroy($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        $order->delete();

        return redirect()->route('orders.checkout')->with('success', 'Đơn hàng đã được xoá thành công.');
    }

    public function payByBalance(Order $order)
{
    $user = Auth::user();

    if ($user->money < $order->total_amount) {
        return redirect()->back()->with('error', 'Số dư không đủ để thanh toán.');
    }

    // Trừ tiền người dùng
    $user->money -= $order->total_amount;
    $user->save();

    // Cập nhật trạng thái đơn hàng
    $order->status = Order::STATUS_PENDING;
    $order->save();

    return redirect()->route('profile.orders')->with('success', 'Thanh toán bằng số dư thành công.');
}

}
