@extends('layout.mainAdmin')

@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold text-primary mb-4">{{ $title }}</h4>
        <div>
            <form class="form-search" method="GET" action="{{ route('orderOk') }}">
                @csrf
                <div class="d-flex align-items-center mb-4">
                    <h4 class="ten-game me-3 mb-0">Tìm kiếm đơn hàng</h4>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_code"
                                placeholder="Tìm theo mã đơn hàng..." value="{{ request('search_code') }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_user"
                                placeholder="Tìm theo tên người đăng ký..." value="{{ request('search_user') }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_campaign"
                                placeholder="Tìm theo tên chiến dịch..." value="{{ request('search_campaign') }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <label for="">Ngày bắt đầu</label>
                            <input class="form-control shadow-none" type="date" name="search_start_date"
                                placeholder="Từ ngày bắt đầu..." value="{{ request('search_start_date') }}">
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12 mb-3">
                            <label for="">Ngày kết thúc</label>
                            <input class="form-control shadow-none" type="date" name="search_end_date"
                                placeholder="Đến ngày kết thúc..." value="{{ request('search_end_date') }}">
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12 d-flex align-items-center">
                            <div class="text-nowrap">
                                <button type="submit" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-search me-2"></i>Tìm kiếm
                                </button>
                                <a href="{{ route('orderOk') }}" class="btn btn-secondary rounded-pill ms-2">
                                    <i class="fas fa-times me-2"></i>Xóa lọc
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-body px-0 table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã đơn</th>
                            <th>Người dùng</th>
                            <th>Chiến dịch</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $key => $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user->name ?? 'Không rõ' }}</td>
                                <td>{{ $order->campaign_name }}</td>
                                <td>{{ $order->start_date->format('d/m/Y') }}</td>
                                <td>{{ $order->end_date->format('d/m/Y') }}</td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                                <td><span class="badge bg-success text-dark fw-bold">Đã duyệt</span></td>
                                <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-info text-dark fw-bold btn-order-detail"
                                        data-id="{{ $order->id }}">
                                        Chi tiết
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">Không có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Modal Chi tiết đơn hàng -->
                <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
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

                <div class="mt-3">
                    {{ $orders->links() }}
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

                    fetch(`/admin/order-detail/${orderId}`)
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
                                <tr><th>Trạng thái</th><td class="text-success">Đã duyệt</td></tr>
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
