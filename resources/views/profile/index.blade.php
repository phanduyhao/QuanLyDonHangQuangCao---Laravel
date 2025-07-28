@extends('layout.main')

@section('contents')
    <div class="container py-4">
        <div class="row g-4">
            @include('components.sidebar_profile')
            <!-- Main content -->
            <div class="col-md-9">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Thông tin cá nhân -->
                <div class="card card-right-profile">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-id-card me-2"></i>Thông Tin Cá Nhân
                        </h5>
                        <form class="row" action="{{ route('profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="col-md-4 text-center">
                                <img src="/images/avatars/{{ Auth::user()->avatar ?? 'avatar.png' }}" id="avatarPreview"
                                    class="img-fluid rounded mb-3" alt="Ảnh đại diện">

                                <input type="file" name="avatar" id="avatarInput" accept="image/*" class="d-none">
                                <button class="btn btn-secondary btn-sm btn-upload">
                                    <i class="fas fa-upload me-2"></i>Upload Ảnh
                                </button>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Tên</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', Auth::user()->name) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', Auth::user()->email) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ old('phone', Auth::user()->phone) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quyền tài khoản</label>
                                    <input type="text" class="form-control" disabled value="{{ Auth::user()->role }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success text-dark fw-bold w-fit ms-auto">Cập nhật</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const uploadBtn = document.querySelector(".btn-upload");
            const fileInput = document.querySelector("#avatarInput");
            const previewImg = document.querySelector("#avatarPreview");

            // Khi click vào nút upload => trigger input file
            uploadBtn?.addEventListener("click", function(e) {
                e.preventDefault();
                fileInput?.click();
            });

            // Khi chọn ảnh mới
            fileInput?.addEventListener("change", function() {
                const file = this.files[0];
                if (file && file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
