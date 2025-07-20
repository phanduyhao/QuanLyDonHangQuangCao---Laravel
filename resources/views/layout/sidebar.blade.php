 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" data-bg-class="bg-menu-theme">
     <div class="app-brand demo justify-content-center">
         <a href="index.html" class="app-brand-link">
             <span class="app-brand-logo demo">
                 <img width="100" src="/temp/images/logo.png" alt="Logo">
             </span>

         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow" style="display: none;"></div>

     <ul class="menu-inner py-1 ps ps--active-y">
         <!-- Dashboard -->
         <li class="menu-item">
             <a href="{{ route('admin') }}" class="menu-link">
                 <i class="menu-icon tf-icons bx bx-home-circle"></i>
                 <div data-i18n="Analytics">Trang quản trị</div>
             </a>
         </li>
         <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Người dùng &amp; Khách hàng</span>
        </li>
         <li class="menu-item active">
            <a href="{{ route('users.index') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Layouts">Quản lý người dùng</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dịch vụ && Đơn hàng</span>
        </li>
         <li class="menu-item active">
            <a href="{{ route('services.index') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Layouts">Quản lý dịch vụ</div>
            </a>
        </li>
         <li class="menu-item active">
            <a href="{{ route('servicesPricing.index') }}" class="menu-link ">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Layouts">Quản lý bảng giá</div>
            </a>
        </li>
     </ul>
 </aside>
