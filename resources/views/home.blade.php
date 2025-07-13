@extends('layout.main')
@section('contents')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-12 mb-4">
                  <h4 class="fw-bold">Loại hình quảng cáo</h4>
                  <p class="text-muted">Chọn loại dịch vụ bạn muốn sử dụng</p>
                </div>

                <!-- Quảng cáo: Banner -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100">
                    <div class="card-body text-center">
                      <img src="https://cdn-icons-png.flaticon.com/512/1625/1625044.png" alt="Banner Ads" width="60" class="mb-3">
                      <h5 class="card-title">Banner</h5>
                      <p class="card-text">Thiết kế &amp; đặt banner trên các
                        website, báo điện tử.</p>
                      <a href="/order/banner" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Quảng cáo: Facebook Ads -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100">
                    <div class="card-body text-center">
                      <img src="https://cdn-icons-png.flaticon.com/512/1384/1384005.png" alt="Facebook Ads" width="60" class="mb-3">
                      <h5 class="card-title">Facebook Ads</h5>
                      <p class="card-text">Quảng cáo bài viết, sản phẩm, fanpage
                        trên Facebook.</p>
                      <a href="/order/facebook" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Quảng cáo: Google Ads -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100">
                    <div class="card-body text-center">
                      <img src="https://cdn-icons-png.flaticon.com/512/732/732228.png" alt="Google Ads" width="60" class="mb-3">
                      <h5 class="card-title">Google Ads</h5>
                      <p class="card-text">Hiển thị quảng cáo tìm kiếm, banner
                        Google Display.</p>
                      <a href="/order/google" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Quảng cáo: Video Marketing -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100">
                    <div class="card-body text-center">
                      <img src="https://cdn-icons-png.flaticon.com/512/1384/1384012.png" alt="Video Ads" width="60" class="mb-3">
                      <h5 class="card-title">Video Marketing</h5>
                      <p class="card-text">Quảng cáo video trên YouTube, TikTok,
                        social media.</p>
                      <a href="/order/video" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100 text-center">
                    <div class="card-body">
                      <img src="https://cdn-icons-png.flaticon.com/512/5968/5968557.png" alt="TikTok Ads" width="60" class="mb-3">
                      <h5 class="card-title">TikTok Ads</h5>
                      <p class="card-text">Tăng lượt xem, follow và chuyển đổi
                        trên TikTok.</p>
                      <a href="/order/tiktok" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Zalo Ads -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100 text-center">
                    <div class="card-body">
                      <img src="https://cdn-icons-png.flaticon.com/512/888/888879.png" alt="Zalo Ads" width="60" class="mb-3">
                      <h5 class="card-title">Zalo Ads</h5>
                      <p class="card-text">Chạy quảng cáo bài viết, tin nhắn
                        trên Zalo OA.</p>
                      <a href="/order/zalo" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Quảng cáo OOH -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100 text-center">
                    <div class="card-body">
                      <img src="https://cdn-icons-png.flaticon.com/512/1982/1982607.png" alt="OOH Ads" width="60" class="mb-3">
                      <h5 class="card-title">Quảng cáo OOH</h5>
                      <p class="card-text">Biển pano, billboard, LED ngoài trời
                        khắp thành phố.</p>
                      <a href="/order/ooh" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Quảng cáo xe buýt / taxi -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100 text-center">
                    <div class="card-body">
                      <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Bus Ads" width="60" class="mb-3">
                      <h5 class="card-title">Ads trên xe buýt/taxi</h5>
                      <p class="card-text">Dán decal quảng cáo trên phương tiện
                        công cộng.</p>
                      <a href="/order/transport" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Influencer Marketing -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100 text-center">
                    <div class="card-body">
                      <img src="https://cdn-icons-png.flaticon.com/512/236/236832.png" alt="KOL" width="60" class="mb-3">
                      <h5 class="card-title">KOL / Influencer</h5>
                      <p class="card-text">Hợp tác với người nổi tiếng quảng bá
                        thương hiệu.</p>
                      <a href="/order/kol" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>

                <!-- Email Marketing -->
                <div class="col-md-6 col-lg-3 mb-4">
                  <div class="card h-100 text-center">
                    <div class="card-body">
                      <img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" alt="Email Marketing" width="60" class="mb-3">
                      <h5 class="card-title">Email Marketing</h5>
                      <p class="card-text">Gửi chiến dịch email đến tệp khách
                        hàng tiềm năng.</p>
                      <a href="/order/email" class="btn btn-outline-primary btn-sm">Đặt dịch vụ</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>2025
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>

                  <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank" class="footer-link me-4">Support</a>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
@endsection