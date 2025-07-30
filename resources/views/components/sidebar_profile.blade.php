<style>
    .profile-sidebar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 30px 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
    }

    .profile-sidebar h5 {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 1.3rem;
    }

    .profile-sidebar p {
        opacity: 0.9;
        margin-bottom: 15px;
    }

    .profile-nav-link {
        color: rgba(255, 255, 255, 0.85) !important;
        padding: 12px 15px !important;
        border-radius: 8px;
        margin-bottom: 8px;
        display: block;
        text-align: left;
        transition: all 0.3s ease;
        font-weight: 500;
        text-decoration: none;
    }

    .profile-nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: white !important;
    }

    .profile-nav-link.active {
        background-color: rgba(255, 255, 255, 0.3) !important;
        color: white !important;
        font-weight: 600;
    }
</style>

<!-- Sidebar -->
<div class="col-md-3">
    <div class="profile-sidebar text-center">
        <img src="/images/avatars/{{ Auth::user()->avatar ?? 'avatar.png' }}" class="profile-avatar" alt="Avatar">
        <h5>{{ Auth::user()->name }}</h5>
        <p>{{ Auth::user()->email }}</p>
        <p>Số dư: {{ number_format(Auth::user()->money) }} VNĐ</p>
        <div class="d-flex flex-column align-items-center border-top pt-3">
            <a href="{{ route('profile.show') }}"
                class="profile-nav-link {{ Route::currentRouteName() == 'profile.show' ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i> Thông Tin Cá Nhân
            </a>
            <a href="{{ route('profile.orders') }}"
                class="profile-nav-link {{ Route::currentRouteName() == 'profile.orders' ? 'active' : '' }}">
                <i class="fas fa-list me-2"></i> Danh Sách Đơn Hàng
            </a>
            <a href="{{ route('profile.change-password') }}"
                class="profile-nav-link {{ Route::currentRouteName() == 'profile.change-password' ? 'active' : '' }}">
                <i class="fas fa-lock me-2"></i> Thay Đổi Mật Khẩu
            </a>
             <a href="{{ route('profile.payment_history') }}"
                class="profile-nav-link {{ Route::currentRouteName() == 'profile.payment_history' ? 'active' : '' }}">
                <i class="fas fa-lock me-2"></i> Lịch sử nạp tiền
            </a>
        </div>
    </div>
</div>
