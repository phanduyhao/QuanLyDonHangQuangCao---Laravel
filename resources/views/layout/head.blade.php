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
  </style>
  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme position-sticky bg-dark" id="layout-navbar" style="top:15px">
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
                      <a class="nav-link text-white fw-bold"  href="/about">Giới thiệu</a>
                  </li>
                  <li class="nav-item me-3">
                      <a class="nav-link text-white fw-bold"  href="/contact">Liên hệ</a>
                  </li>
              </ul>

          </div>

          <!-- RIGHT SIDE: Icons + Avatar -->
          
          <div class="d-flex align-items-center">
            @auth
              <!-- Giỏ hàng -->
              <a class="nav-link position-relative me-3" href="/cart">
                  <i class="bx bx-cart" style="font-size: 1.5rem;"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      3
                  </span>
              </a>

              <!-- Thông báo -->
              <a class="nav-link position-relative me-3" href="/notifications">
                  <i class="bx bx-bell" style="font-size: 1.5rem;"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      3
                  </span>
              </a>

              <!-- Avatar + Dropdown -->
              <div class="dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                      <div class="avatar avatar-online">
                          <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                              class="w-px-40 h-auto rounded-circle">
                      </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item" href="#">
                              <div class="d-flex">
                                  <div class="flex-shrink-0 me-3">
                                      <div class="avatar avatar-online">
                                          <img src="{{ asset('assets/img/avatars/1.png') }}" alt=""
                                              class="w-px-40 h-auto rounded-circle">
                                      </div>
                                  </div>
                                  <div class="flex-grow-1">
                                      <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                      <small
                                          class="text-muted">{{ Auth::user()->role == 'user' ? 'Người dùng' : 'Quản trị' }}</small>
                                  </div>
                              </div>
                          </a>
                      </li>
                      <li>
                          <div class="dropdown-divider"></div>
                      </li>
                      <li><a class="dropdown-item" href="#"><i class="bx bx-user me-2"></i>Trang cá nhân</a></li>
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
