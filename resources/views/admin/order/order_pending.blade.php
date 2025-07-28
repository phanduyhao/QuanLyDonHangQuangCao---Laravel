@extends('layout.mainAdmin')

@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold text-warning mb-4">{{ $title }}</h4>
        <div>
            <form class="form-search" method="GET" action="{{ route('orderPending') }}">
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
                                <a href="{{ route('orderPending') }}" class="btn btn-secondary rounded-pill ms-2">
                                    <i class="fas fa-times me-2"></i>Xóa lọc
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body table-responsive">
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
                                <td><span class="badge bg-warning text-dark">Chờ duyệt</span></td>
                                <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                                <td class="d-flex flex-column">
                                    <button class="btn mt-2 btn-info text-dark fw-bold btn-order-detail"
                                        data-id="{{ $order->id }}">
                                        Chi tiết
                                    </button>
                                    <form class="mt-2" action="" action="">
                                        @csrf
                                        <button type="submit" class="btn btn-success text-dark fw-bold btn-order-detail">
                                            Duyệt đơn
                                        </button>
                                    </form>
                                    <button class="btn mt-2 btn-danger text-white fw-bold btn-order-cancel"
                                        data-id="{{ $order->id }}" data-code="{{ $order->order_code }}">
                                        Hủy đơn
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
                <!-- Modal Hủy đơn -->
                <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" id="cancel-order-form">
                            @csrf
                            <input type="hidden" name="order_id" id="cancel_order_id">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelOrderModalLabel">Hủy đơn hàng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Đóng"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Mã đơn hàng:</strong> <span id="cancel_order_code"></span></p>
                                    <div class="mb-3">
                                        <label for="rejection_reason" class="form-label">Lý do hủy đơn</label>
                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                </div>
                            </div>
                        </form>
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
                                <tr><th>Tổng reach</th><td>${order.reach_total}</td></tr>
                                <tr><th>Tổng tiền</th><td>${new Intl.NumberFormat().format(order.total_amount)}₫</td></tr>
                                <tr><th>Trạng thái</th><td class="text-warning">Chưa duyệt</td></tr>
                                <tr><th>Lý do từ chối</th><td>${order.rejection_reason ?? 'Không có'}</td></tr>
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
    <script>
$(document).ready(function () {
    $('.btn-order-cancel').on('click', function () {
        const orderId = $(this).data('id');
        const orderCode = $(this).data('code');

        // Gán dữ liệu vào modal
        $('#cancel_order_id').val(orderId);
        $('#cancel_order_code').text(orderCode);
        $('#rejection_reason').val('');

        // Mở modal
        $('#cancelOrderModal').modal('show');
    });

    // Xử lý submit form nếu cần gửi về backend
    $('#cancel-order-form').on('submit', function (e) {
        // Có thể bỏ qua nếu đã dùng action/form route trong <form>
        e.preventDefault();
        const orderId = $('#cancel_order_id').val();
        const reason = $('#rejection_reason').val();

        $.ajax({
            url: `/admin/orders/${orderId}/cancel`, // ví dụ
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                rejection_reason: reason
            },
            success: function (res) {
                alert('Đã hủy đơn thành công!');
                $('#cancelOrderModal').modal('hide');
                location.reload();
            },
            error: function (err) {
                alert('Hủy đơn thất bại.');
            }
        });
    });
});
</script>

@endsection
