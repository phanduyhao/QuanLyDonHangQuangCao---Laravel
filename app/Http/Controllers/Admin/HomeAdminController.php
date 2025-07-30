<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use PDF;

class HomeAdminController extends Controller
{
   
public function index()
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

    return view('admin.dasboard', compact(
        'revenueToday',
        'revenueMonth',
        'revenueTotal',
        'totalOrdersToday',
        'totalOrdersMonth',
        'approvedOrders',
        'pendingOrders',
        'rejectedOrders'
    ), [
        'title' => 'Thống kê & báo cáo'
    ]);
}


    // public function exportExcel()
    // {
    //     return Excel::download(new ReportExport(), 'report.xlsx');
    // }

    // public function exportPDF()
    // {
    //     $data = [
    //         // có thể truyền các biến đã tính toán ở trên
    //     ];
    //     $pdf = PDF::loadView('admin.reports.pdf', $data);
    //     return $pdf->download('report.pdf');
    // }
}
