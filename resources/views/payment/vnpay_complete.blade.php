@extends('layout.main')

@section('contents')
<div class="container mt-5">
    <div class="card shadow rounded-3">
        <div class="card-body text-center">
            <div class="mb-4">
                <i class="bx bx-check-circle text-success" style="font-size: 4rem;"></i>
                <h2 class="text-success">Thanh toán thành công!</h2>
                <p class="text-muted">Cảm ơn bạn đã đặt dịch vụ. Chúng tôi đã nhận được đơn hàng của bạn.</p>
            </div>

            <div class="text-start mx-auto" style="max-width: 500px;">
                <h5>Thông tin đơn hàng:</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Mã đơn hàng:</strong></span>
                        <span>{{ $order->order_code }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Tên chiến dịch:</strong></span>
                        <span>{{ $order->campaign_name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Thời gian chạy:</strong></span>
                        <span>{{ $order->start_date }} - {{ $order->end_date }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Số ngày:</strong></span>
                        <span>{{ $order->number_of_days }} ngày</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><strong>Tổng tiền:</strong></span>
                        <span>{{ number_format($order->total, 0, ',', '.') }} VNĐ</span>
                    </li>
                </ul>
            </div>

            <div class="mt-4">
                <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
                {{-- Hoặc xem chi tiết đơn hàng --}}
                {{-- <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary">Xem chi tiết đơn hàng</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection