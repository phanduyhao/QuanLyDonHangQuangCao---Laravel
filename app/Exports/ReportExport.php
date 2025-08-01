<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Order;
use Carbon\Carbon;

class ReportExport implements FromView
{
    public function view(): View
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();
         // Doanh thu
        $revenueToday = Order::whereDate('created_at', $today)
            ->where('status', Order::STATUS_OK)
            ->sum('total_amount');

        $revenueMonth = Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', Order::STATUS_OK)
            ->sum('total_amount');

        $revenueTotal = Order::where('status', Order::STATUS_OK)->sum('total_amount');

        // Tổng đơn theo ngày/tháng
        $totalOrdersToday = Order::whereDate('created_at', $today)
            ->whereNotNull('status')
            ->count();

        $totalOrdersMonth = Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->whereNotNull('status')
            ->count();

        // Trạng thái đơn
        $approvedOrders = Order::where('status', Order::STATUS_OK)->count();
        $pendingOrders = Order::where('status', Order::STATUS_PENDING)->count();
        $rejectedOrders = Order::where('status', Order::STATUS_CANCEL)->count();
        $data = [
            'revenueToday' => $revenueToday,
            'revenueMonth' => $revenueMonth,
            'totalRevenue' => $revenueTotal,
            'totalOrdersToday' => $totalOrdersToday,
            'totalOrdersMonth' => $totalOrdersMonth,
            'approvedOrders' => $approvedOrders,
            'pendingOrders' => $pendingOrders,
            'rejectedOrders' => $rejectedOrders,
        ];

        return view('admin.reports.excel', $data);
    }
}
