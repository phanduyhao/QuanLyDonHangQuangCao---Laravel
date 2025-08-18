<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCancelledMail;

class AdminOrderController extends Controller
{
    public function orderOk(Request $request)
    {
        $query = Order::where('status', Order::STATUS_OK);

        // Tìm theo mã đơn hàng
        if ($request->filled('search_code')) {
            $query->where('order_code', 'like', '%' . $request->search_code . '%');
        }

        // Tìm theo tên người đăng ký
        if ($request->filled('search_user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_user . '%');
            });
        }

        // Tìm theo tên chiến dịch
        if ($request->filled('search_campaign')) {
            $query->where('campaign_name', 'like', '%' . $request->search_campaign . '%');
        }

        // Tìm từ ngày bắt đầu
        if ($request->filled('search_start_date')) {
            $query->whereDate('start_date', '>=', $request->search_start_date);
        }

        // Tìm đến ngày kết thúc
        if ($request->filled('search_end_date')) {
            $query->whereDate('end_date', '<=', $request->search_end_date);
        }

        $orders = $query->orderByDesc('id')->paginate(10)->appends($request->query());

        return view('admin.order.order_ok', compact('orders'), [
            'title' => 'Danh sách đơn hàng đã duyệt',
        ]);
    }



    public function OrderPending(Request $request)
    {
        $query = Order::where('status', Order::STATUS_PENDING);

        // Tìm theo mã đơn hàng
        if ($request->filled('search_code')) {
            $query->where('order_code', 'like', '%' . $request->search_code . '%');
        }

        // Tìm theo tên người đăng ký
        if ($request->filled('search_user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_user . '%');
            });
        }

        // Tìm theo tên chiến dịch
        if ($request->filled('search_campaign')) {
            $query->where('campaign_name', 'like', '%' . $request->search_campaign . '%');
        }

        // Tìm từ ngày bắt đầu
        if ($request->filled('search_start_date')) {
            $query->whereDate('start_date', '>=', $request->search_start_date);
        }

        // Tìm đến ngày kết thúc
        if ($request->filled('search_end_date')) {
            $query->whereDate('end_date', '<=', $request->search_end_date);
        }

        $orders = $query->orderByDesc('id')->paginate(10)->appends($request->query());

        return view('admin.order.order_pending', compact('orders'), [
            'title' => 'Danh sách đơn hàng chưa duyệt',
        ]);
    }
    public function OrderCancel(Request $request)
    {
        $query = Order::where('status', Order::STATUS_CANCEL);

        // Tìm theo mã đơn hàng
        if ($request->filled('search_code')) {
            $query->where('order_code', 'like', '%' . $request->search_code . '%');
        }

        // Tìm theo tên người đăng ký
        if ($request->filled('search_user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_user . '%');
            });
        }

        // Tìm theo tên chiến dịch
        if ($request->filled('search_campaign')) {
            $query->where('campaign_name', 'like', '%' . $request->search_campaign . '%');
        }

        // Tìm từ ngày bắt đầu
        if ($request->filled('search_start_date')) {
            $query->whereDate('start_date', '>=', $request->search_start_date);
        }

        // Tìm đến ngày kết thúc
        if ($request->filled('search_end_date')) {
            $query->whereDate('end_date', '<=', $request->search_end_date);
        }

        $orders = $query->orderByDesc('id')->paginate(10)->appends($request->query());

        return view('admin.order.order_cancel', compact('orders'), [
            'title' => 'Danh sách đơn hàng đã hủy',
        ]);
    }

    public function orderDetail($id)
    {
        $order = Order::with('user')->find($id); // 👈 Load cả quan hệ user

        if (!$order) {
            return response()->json([
                'message' => 'Không tìm thấy đơn hàng với ID: ' . $id
            ], 404);
        }

        return response()->json($order);
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::with('user')->findOrFail($id);

        $order->status = Order::STATUS_CANCEL;
        $order->rejection_reason = $request->rejection_reason;
        $order->save();

        // Gửi mail
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderCancelledMail($order));
        }

        return response()->json(['success' => true]);
    }

    public function approve($id)
    {
        $order = Order::with('user')->findOrFail($id);

        $order->status = Order::STATUS_OK;
        $order->save();
        return redirect()->route('orderOk')
            ->with('success', 'Đơn hàng đã được duyệt thành công!');
    }
}
