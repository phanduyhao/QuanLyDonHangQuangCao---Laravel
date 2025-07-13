@extends('layout.main')
@section('contents')
  <div class="container d-flex align-items-center justify-content-center min-vh-100">
       @include('layout.sidebar')
    
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
      <h4 class="mb-3 text-center">Đăng nhập</h4>
      <form action="/login" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" required />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" name="password" id="password" required />
        </div>

        <div class="d-grid mb-3">
          <button type="submit" class="btn btn-primary">Đăng nhập</button>
        </div>

        <div class="text-center">
          <a href="/register">Chưa có tài khoản? Đăng ký</a>
        </div>
      </form>
    </div>
  </div>
@endsection
