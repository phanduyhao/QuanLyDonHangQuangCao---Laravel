@extends('layout.main')

@section('contents')
<div class="container py-4">
    <div class="row g-4">
        @include('components.sidebar_profile')

        <div class="col-md-9">
            <div class="card" style="background-color: antiquewhite;">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-key me-2"></i>Đổi mật khẩu
                    </h5>

                    <!-- Hiển thị thông báo -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form đổi mật khẩu -->
                    <form action="{{ route('profile.changePassword') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save me-1"></i> Cập nhật mật khẩu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
