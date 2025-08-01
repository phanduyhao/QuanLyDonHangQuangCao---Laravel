@extends('layout.main')

@section('contents')
    <style>
        .nav-tabs .nav-link.active {
            background-color: black;
            color: white;
        }
    </style>
    <div class="container py-4">
        <div class="row g-4">
            @include('components.sidebar_profile')

            <!-- Cột phải -->
            <div class="col-md-9">
                <div class="card" style="background-color: antiquewhite;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-shopping-cart me-2"></i>{{ $title ?? 'Đơn hàng của bạn' }}
                        </h5>

                        <!-- Tabs điều hướng bằng link -->
                        <ul class="nav nav-tabs mb-3">

                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == null ? 'active' : '' }}"
                                    href="{{ route('profile.orders') }}">
                                    Tất cả
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}"
                                    href="{{ route('profile.orders', ['status' => 0]) }}">
                                    Chờ duyệt
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 1 ? 'active' : '' }}"
                                    href="{{ route('profile.orders', ['status' => 1]) }}">
                                    Đã duyệt
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 2 ? 'active' : '' }}"
                                    href="{{ route('profile.orders', ['status' => 2]) }}">
                                    Đã hủy
                                </a>
                            </li>
                        </ul>

                        <!-- Bảng đơn hàng -->
                        @if ($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr class="text-dark">
                                            <th>#</th>
                                            <th>Mã đơn</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            <tr class="text-dark">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $order->order_code }}</td>
                                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                                <td>
                                                    @if ($order->status == 1)
                                                        <span class="badge bg-success text-dark">Đã duyệt</span>
                                                    @elseif ($order->status == 2)
                                                        <span class="badge bg-danger">Đã Hủy</span>
                                                    @elseif ($order->status == 0)
                                                        <span class="badge bg-warning">Chờ duyệt</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-info text-dark fw-bold btn-order-detail"
                                                        data-id="{{ $order->id }}">
                                                        Chi tiết
                                                    </button>
                                                    @if ($order->status == 0)
                                                        <form action="{{ route('profile.orders.cancel', $order->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')"
                                                            class="d-inline">
                                                            @csrf
                                                            <button class="btn btn-danger">Hủy đơn</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Modal Chi tiết đơn hàng -->
                                <div class="modal fade" id="orderDetailModal" tabindex="-1"
                                    aria-labelledby="orderDetailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold" id="orderDetailModalLabel">Chi tiết đơn hàng
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Đóng"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="order-detail-content">
                                                    <div class="text-center">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="visually-hidden">Đang tải...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">Không có đơn hàng nào trong mục này.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));

            document.querySelectorAll('.btn-order-detail').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-id');
                    const contentDiv = document.getElementById('order-detail-content');

                    contentDiv.innerHTML = `<div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>`;

                    fetch(`/order-detail/${orderId}`)
                        .then(res => {
                            if (!res.ok) throw new Error('Không tìm thấy đơn hàng!');
                            return res.json();
                        })
                        .then(order => {

                            document.getElementById('orderDetailModalLabel').textContent =
                                `Chi tiết đơn hàng #${order.order_code}`;
                            contentDiv.innerHTML = `
                            <table class="table table-bordered text-dark fw-bold">
                                <tr><th>Người đăng ký</th><td>${order.user?.name ?? 'Không rõ'}</td></tr>
                                <tr><th>Tên chiến dịch</th><td>${order.campaign_name ?? 'Không có'}</td></tr>
                                <tr><th>Nội dung chiến dịch</th><td>${order.campaign_content ?? 'Không có'}</td></tr>
                                <tr><th>Ngày bắt đầu</th><td>${formatDate(order.start_date)}</td></tr>
                                <tr><th>Ngày kết thúc</th><td>${formatDate(order.end_date)}</td></tr>
                                <tr><th>Số ngày</th><td>${order.number_of_days}</td></tr>
                                <tr><th>tổng lượt tiếp cận</th><td>${order.reach_total}</td></tr>
                                <tr><th>Tổng tiền</th><td>${new Intl.NumberFormat().format(order.total_amount)}₫</td></tr>
                                <tr><th>Trạng thái</th><td>${getStatusText(order.status)}</td></tr>
                                <tr><th>Lý do từ chối</th><td class="text-danger">${order.rejection_reason ?? 'Không có'}</td></tr>
                                <tr><th>Ngày tạo</th><td>${formatDate(order.created_at)}</td></tr>
                            </table>
                        `;
                        })
                        .catch(err => {
                            contentDiv.innerHTML =
                                `<div class="alert alert-danger">${err.message}</div>`;
                        });
                    modal.show();
                });
            });
        });

function getStatusText(status) {
    const map = {
        0: `<span class="text-warning">Chờ duyệt</span>`,
        1: `<span class="text-success">Đã duyệt</span>`,
        2: `<span class="text-danger">Đã hủy</span>`,
    };

    return map[+status] || `<span class="text-muted">Không xác định (${status})</span>`;
}


        function formatDate(dateStr) {
            const date = new Date(dateStr);
            const d = date.getDate().toString().padStart(2, '0');
            const m = (date.getMonth() + 1).toString().padStart(2, '0');
            const y = date.getFullYear();
            const h = date.getHours().toString().padStart(2, '0');
            const min = date.getMinutes().toString().padStart(2, '0');
            return `${h}:${min} ${d}/${m}/${y}`;
        }
    </script>
@endsection
