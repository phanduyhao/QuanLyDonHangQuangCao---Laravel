@extends('layout.main')
@section('contents')
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
       @include('layout.sidebar')
    <div class="card shadow-sm p-4" style="max-width: 500px; width: 100%;">
      <h4 class="mb-3 text-center">Tạo tài khoản</h4>
      <form action="/register" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label">Họ và tên</label>
          <input type="text" class="form-control" name="name" id="name" required="">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" required="">
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Số điện thoại</label>
          <input type="tel" class="form-control" name="phone" id="phone" required="">
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" name="password" id="password" required="">
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-success">Đăng ký</button>
        </div>

        <div class="text-center">
          <a href="/login">Đã có tài khoản? Đăng nhập</a>
        </div>
      </form>
    </div>
  </div>
@endsection
