  <style>
      .navbar-nav .nav-link {
          font-weight: 500;
          color: #555;
          position: relative;
          transition: color 0.3s ease;
      }

      .navbar-nav .nav-link:hover {
          color: #0d6efd;
          /* Bootstrap primary */
      }

      .navbar-nav .nav-link::after {
          content: '';
          display: block;
          width: 0%;
          height: 2px;
          background: #0d6efd;
          transition: width 0.3s ease;
          position: absolute;
          bottom: -4px;
          left: 0;
      }

      .navbar-nav .nav-link:hover::after {
          width: 100%;
      }

      .img-banner {
          border-radius: 1.5rem;
          aspect-ratio: 3;
          height: auto;
          object-fit: cover;
      }

      .card-right-profile {
          background-color: antiquewhite !important;
      }

      .w-fit {
          width: fit-content;
      }

      .cart-a {
          color: white;
          border: 1px solid white;
          border-radius: 50%;
          padding: 5px;
      }
  </style>
  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme position-sticky bg-dark"
      id="layout-navbar" style="top:15px">
      <div class="container-fluid d-flex justify-content-between align-items-center">

          <!-- LEFT SIDE: Logo + Menu -->
          <div class="d-flex align-items-center">
              <!-- LOGO -->
              <a class="navbar-brand d-flex align-items-center me-4" href="{{ route('home') }}">
                  <img src="/temp/images/logo.png" alt="Logo" style="height: 50px;" class="me-2">
              </a>

              <!-- Menu Links -->
              <ul class="navbar-nav d-flex flex-row">
                  <li class="nav-item me-3">
                      <a class="nav-link  text-white fw-bold" href="/">Trang chủ</a>
                  </li>
                  <li class="nav-item me-3">
                      <a class="nav-link text-white fw-bold" href="/about">Giới thiệu</a>
                  </li>
                  <li class="nav-item me-3">
                      <a class="nav-link text-white fw-bold" href="/contact">Liên hệ</a>
                  </li>
              </ul>

          </div>

          <!-- RIGHT SIDE: Icons + Avatar -->

          <div class="d-flex align-items-center">
              @auth
                  <a href="javascript:void(0)" class="btn btn-primary me-2" data-bs-toggle="modal"
                      data-bs-target="#depositModal">
                      Nạp tiền
                  </a>
                  <!-- Giỏ hàng -->
                  <a class="nav-link position-relative me-3 cart-a" href="/checkout">
                      <i class="bx bx-cart" style="font-size: 1.5rem;"></i>
                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                          {{ $count_order_pending_payment }}
                      </span>
                  </a>

                  {{-- <!-- Thông báo -->
              <a class="nav-link position-relative me-3" href="/notifications">
                  <i class="bx bx-bell" style="font-size: 1.5rem;"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      3
                  </span>
              </a> --}}

                  <!-- Avatar + Dropdown -->
                  <div class="dropdown">
                      <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                          <div class="avatar avatar-online">
                              <img src="/images/avatars/{{ Auth::user()->avatar ?? 'avatar.png' }}" alt="Avatar"
                                  class="w-px-40 h-auto rounded-circle">
                          </div>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                          <li>
                              <a class="dropdown-item" href="{{ route('profile.show') }}">
                                  <div class="d-flex">
                                      <div class="flex-shrink-0 me-3">
                                          <div class="avatar avatar-online">
                                              <img src="/images/avatars/{{ Auth::user()->avatar ?? 'avatar.png' }}"
                                                  alt="" class="w-px-40 h-auto rounded-circle">
                                          </div>
                                      </div>
                                      <div class="flex-grow-1">
                                          <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                          <b class="text-info">{{ number_format(Auth::user()->money) }} VNĐ</b>
                                      </div>
                                  </div>
                              </a>
                          </li>
                          <li>
                              <div class="dropdown-divider"></div>
                          </li>
                          <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i
                                      class="bx bx-user me-2"></i>Trang cá nhân</a></li>
                          @if (Auth::user()->role == 'admin')
                              <li><a class="dropdown-item" href="{{ route('admin') }}"><i class="bx bx-cog me-2"></i>Quản
                                      trị</a></li>
                          @endif
                          <li>
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  <i class="bx bx-power-off me-2"></i>Đăng xuất
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                  @csrf
                              </form>
                          </li>
                      </ul>
                  </div>
              @else
                  <!-- Đăng nhập/Đăng ký -->
                  <div class="d-flex">
                      <a href="{{ route('showLogin') }}" class="btn btn-primary me-2">Đăng nhập</a>
                      <a href="{{ route('showRegister') }}" class="btn btn-secondary">Đăng ký</a>
                  </div>
              @endauth
          </div>
      </div>
  </nav>
<!-- Modal Nạp tiền -->
<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('payment.deposit') }}" method="POST" id="depositForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositModalLabel">Nạp tiền</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Số tiền muốn nạp (VNĐ)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="10000"
                            placeholder="Nhập số tiền (>= 10.000)" required>
                        <div class="invalid-feedback d-block" id="amountError" style="display: none;">
                            Số tiền phải lớn hơn hoặc bằng 10.000 VNĐ.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success" id="submitDepositBtn" disabled>Nạp</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JS kiểm tra realtime -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const amountInput = document.getElementById('amount');
        const errorMsg = document.getElementById('amountError');
        const submitBtn = document.getElementById('submitDepositBtn');

        function validateAmount() {
            const value = parseInt(amountInput.value);
            if (isNaN(value) || value < 10000) {
                errorMsg.style.display = 'block';
                amountInput.classList.add('is-invalid');
                submitBtn.disabled = true;
            } else {
                errorMsg.style.display = 'none';
                amountInput.classList.remove('is-invalid');
                submitBtn.disabled = false;
            }
        }

        amountInput.addEventListener('input', validateAmount);

        // Reset khi modal mở lại (nếu cần)
        document.getElementById('depositModal').addEventListener('shown.bs.modal', function () {
            validateAmount();
        });
    });
</script>
