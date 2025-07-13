  <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Giỏ hàng -->
                <li class="nav-item lh-1 me-3">
                  <a class="nav-link position-relative" href="/cart">
                    <i class="bx bx-cart" style="font-size: 1.5rem;"></i>
                    <!-- Badge số lượng đơn (nếu có) -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      3
                      <span class="visually-hidden">unread messages</span>
                    </span>
                  </a>
                </li>

                <!-- Nút Đăng ký -->
                <li class="nav-item me-2">
                  <a class="btn btn-outline-primary" href="{{ route('showRegister') }}">Đăng
                    ký</a>
                </li>

                <!-- Nút Đăng nhập -->
                <li class="nav-item me-3">
                  <a class="btn btn-primary" href="{{ route('showLogin') }}">Đăng nhập</a>
                </li>

                <!-- User Dropdown -->

              </ul>

            </div>
          </nav>