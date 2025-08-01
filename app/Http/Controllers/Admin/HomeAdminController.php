<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

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


    public function exportPDF()
    {
        $data = $this->getReportData(); // gọi lại logic thống kê
        $pdf = Pdf::loadView('admin.reports.pdf', $data);
        return $pdf->download('bao-cao-doanh-thu.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ReportExport, 'bao-cao-doanh-thu.xlsx');
    }

    private function getReportData()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        return [
            // Doanh thu
            'revenueToday' => Order::whereDate('created_at', $today)
                ->where('status', Order::STATUS_OK)
                ->sum('total_amount'),

            'revenueMonth' => Order::whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('status', Order::STATUS_OK)
                ->sum('total_amount'),

            'totalRevenue' => Order::where('status', Order::STATUS_OK)->sum('total_amount'),

            // Tổng đơn
            'totalOrdersToday' => Order::whereDate('created_at', $today)
                ->whereNotNull('status')
                ->count(),

            'totalOrdersMonth' => Order::whereBetween('created_at', [$monthStart, $monthEnd])
                ->whereNotNull('status')
                ->count(),

            // Trạng thái đơn
            'approvedOrders' => Order::where('status', Order::STATUS_OK)->count(),
            'pendingOrders' => Order::where('status', Order::STATUS_PENDING)->count(),
            'rejectedOrders' => Order::where('status', Order::STATUS_CANCEL)->count(),
        ];
    }
}
