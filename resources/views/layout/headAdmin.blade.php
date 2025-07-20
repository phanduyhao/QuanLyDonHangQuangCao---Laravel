<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- LEFT SIDE: Logo + Menu -->
        <div class="d-flex align-items-center">
            <!-- Menu Links -->
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item me-3">
                    <a class="nav-link text-dark fw-bold bg-label-danger rounded-3" href="/">Trang Website</a>
                </li>
            </ul>
        </div>

        <!-- RIGHT SIDE: Icons + Avatar -->
        <div class="d-flex align-items-center">
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
                                    <small class="text-muted">{{ Auth::user()->role == 'user' ? 'Người dùng' : 'Quản trị' }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li><a class="dropdown-item" href="#"><i class="bx bx-user me-2"></i>Trang cá nhân</a></li>
                    @if(Auth::user()->role == 'admin')
                        <li><a class="dropdown-item" href="{{ route('admin') }}"><i class="bx bx-cog me-2"></i>Quản trị</a></li>
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
        </div>
    </div>
</nav>
