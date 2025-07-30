@extends('layout.main')

@section('contents')
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h4>Tài khoản của bạn đã bị khóa</h4>
            @if ($reason)
                <p><strong>Lý do:</strong> {{ $reason }}</p>
            @endif
            <p>Vui lòng liên hệ quản trị viên để biết thêm chi tiết.</p>
        </div>
    </div>
@endsection
