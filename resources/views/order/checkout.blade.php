@extends('layout.main')

@section('contents')
    <style>
        th {
            color: white !important;
        }
    </style>

    <div id="heroBanner" class="container carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/images/banner/banner1.jpg" class="d-block w-100 img-banner" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="/images/banner/banner2.jpg" class="d-block w-100 img-banner" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="/images/banner/banner3.jpg" class="d-block w-100 img-banner" alt="Banner 3">
            </div>
            <div class="carousel-item">
                <img src="/images/banner/banner4.png" class="d-block w-100 img-banner" alt="Banner 4">
            </div>
        </div>

        <!-- Điều hướng trái/phải -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Tiếp</span>
        </button>
    </div>

    <div class="container mt-4">
        <h2 class="mb-4 fw-bold">Các đơn hàng đang chờ thanh toán</h2>

        @if ($orders->isEmpty())
            <div class="alert alert-info">
                Hiện không có đơn hàng nào đang chờ thanh toán.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Mã đơn hàng</th>
                            <th>Tên chiến dịch</th>
                            <th>Thời gian chạy</th>
                            <th>Số ngày</th>
                            <th>Tổng lượt tiếp cận</th>
                            <th>Tổng tiền</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $order->order_code }}</strong></td>
                                <td>{{ $order->campaign_name ?? '---' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($order->start_date)->format('d/m/Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($order->end_date)->format('d/m/Y') }}
                                </td>
                                <td>{{ $order->number_of_days }} ngày</td>
                                <td>{{ $order->reach_total }} lượt</td>
                                <td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success"
                                        onclick="openPaymentModal({{ $order->id }}, {{ $order->total_amount }})">
                                        Thanh toán
                                    </button>


                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xoá đơn hàng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Modal thanh toán -->
                <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Xác nhận thanh toán</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body" id="paymentModalBody">
                                <!-- Nội dung sẽ được JavaScript cập nhật -->
                            </div>
                            <div class="modal-footer" id="paymentModalFooter">
                                <!-- Footer sẽ được JS cập nhật -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
    <script>
        const userBalance = {{ Auth::user()->money ?? 0 }};

        function openPaymentModal(orderId, totalAmount) {
            const modalBody = document.getElementById('paymentModalBody');
            const modalFooter = document.getElementById('paymentModalFooter');
            modalBody.innerHTML = '';
            modalFooter.innerHTML = '';

            if (userBalance >= totalAmount) {
                modalBody.innerHTML = `<p>Số dư của bạn là <strong>${userBalance.toLocaleString()} VNĐ</strong>.</p>
                <p>Chi phí đơn hàng là <strong>${totalAmount.toLocaleString()} VNĐ</strong>.</p>
                <p>Bạn muốn chọn phương thức thanh toán nào?</p>`;
                modalFooter.innerHTML = `
                <form method="POST" action="/orders/${orderId}/pay-by-balance">
                    @csrf
                    <button type="submit" class="btn btn-primary">Thanh toán bằng số dư</button>
                </form>
                <a href="/payment/${orderId}" class="btn btn-success">Thanh toán bằng VNPay</a>
            `;
            } else {
                modalBody.innerHTML = `<p class="text-danger">Số dư tài khoản của bạn (<strong>${userBalance.toLocaleString()} VNĐ</strong>) không đủ để thanh toán đơn hàng này.</p>
                <p>Vui lòng sử dụng VNPay để tiếp tục thanh toán.</p>`;
                modalFooter.innerHTML = `
                <a href="/payment/${orderId}" class="btn btn-success">Thanh toán bằng VNPay</a>
            `;
            }

            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();
        }
    </script>

@endsection
