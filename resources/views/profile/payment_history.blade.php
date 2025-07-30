@extends('layout.main')

@section('contents')
    <div class="container py-4">
        <div class="row g-4">
            @include('components.sidebar_profile')

            <!-- Main content -->
            <div class="col-md-9">
                <div class="card card-right-profile">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-money-check-alt me-2"></i>Lịch Sử Nạp Tiền
                        </h5>

                        @if ($histories->isEmpty())
                            <div class="alert alert-info">Bạn chưa có giao dịch nạp tiền nào.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Mã giao dịch</th>
                                            <th>Số tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Thời gian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($histories as $index => $history)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $history->TransactionNo }}</td>
                                                <td>{{ number_format($history->amount_money, 0, ',', '.') }} đ</td>
                                                <td>
                                                    @if ($history->payment_status == 1)
                                                        <span class="badge bg-success">Thành công</span>
                                                    @elseif($history->payment_status == 0)
                                                        <span class="badge bg-warning text-dark">Đang xử lý</span>
                                                    @else
                                                        <span class="badge bg-danger">Thất bại</span>
                                                    @endif
                                                </td>
                                                <td>{{ $history->created_at->format('H:i d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
