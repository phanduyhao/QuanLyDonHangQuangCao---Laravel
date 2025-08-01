@extends('layout.mainAdmin')

@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Trang quản trị /</span> {{ $title }}
        </h4>
        <div>
            <a href="{{ route('admin.report.pdf') }}" class="btn btn-danger me-2">
                <i class="fas fa-file-pdf"></i> Xuất PDF
            </a>
            <a href="{{ route('admin.report.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Xuất Excel
            </a>
        </div>
        <div class="row">
            {{-- Doanh thu hôm nay --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">💰 Doanh thu hôm nay</span>
                        </div>
                        <h4 class="mb-0 text-success">{{ number_format($revenueToday, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
            </div>

            {{-- Doanh thu tháng này --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">📅 Doanh thu tháng</span>
                        </div>
                        <h4 class="mb-0 text-success">{{ number_format($revenueMonth, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
            </div>

            {{-- Tổng doanh thu --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">📈 Tổng doanh thu</span>
                        </div>
                        <h4 class="mb-0 text-primary">{{ number_format($revenueTotal, 0, ',', '.') }} đ</h4>
                    </div>
                </div>
            </div>

            {{-- Đơn hàng hôm nay --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">🛒 Đơn hôm nay</span>
                        </div>
                        <h4 class="mb-0 text-info">{{ $totalOrdersToday }}</h4>
                    </div>
                </div>
            </div>

            {{-- Đơn hàng tháng này --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">🗓️ Đơn tháng</span>
                        </div>
                        <h4 class="mb-0 text-info">{{ $totalOrdersMonth }}</h4>
                    </div>
                </div>
            </div>

            {{-- Đơn đã duyệt --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">✅ Đơn Đã duyệt</span>
                        </div>
                        <h4 class="mb-0 text-success">{{ $approvedOrders }}</h4>
                    </div>
                </div>
            </div>

            {{-- Đơn chờ duyệt --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">⏳ Đơn Chờ duyệt</span>
                        </div>
                        <h4 class="mb-0 text-warning">{{ $pendingOrders }}</h4>
                    </div>
                </div>
            </div>

            {{-- Đơn đã hủy --}}
            <div class="col-lg-3 col-md-6 col-12 mb-4">
                <div class="card border">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <span class="fw-semibold d-block mb-1 fs-6">❌ Đơn Đã huỷ</span>
                        </div>
                        <h4 class="mb-0 text-danger">{{ $rejectedOrders }}</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
