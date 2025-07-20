@extends('layout.main')

@section('title', 'Giới thiệu - BÌNH MINH')

@section('contents')
    <style>
        .about-section {
            padding: 60px 0;
        }

        .about-title {
            font-weight: bold;
            font-size: 32px;
        }

        .about-description {
            font-size: 18px;
            line-height: 1.8;
        }

        .about-image {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .core-values li {
            margin-bottom: 10px;
        }

        .highlight {
            font-weight: bold;
            color: #0d6efd;
        }

        @media (max-width: 768px) {
            .about-title {
                font-size: 26px;
            }

            .about-description {
                font-size: 16px;
            }
        }
    </style>

    <div class="container about-section px-5 bg-white mt-4">
        <!-- Giới thiệu chung -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="/images/about-us.jpg" alt="Giới thiệu Bình Minh" class="about-image">
            </div>
            <div class="col-md-6">
                <h2 class="about-title text-primary mb-3">Chúng tôi là BÌNH MINH</h2>
                <p class="about-description text-muted">
                    Được thành lập với sứ mệnh <span class="highlight">“Thắp sáng thương hiệu Việt”</span>,
                    <strong>BÌNH MINH</strong> là đơn vị cung cấp dịch vụ quảng cáo, truyền thông và công nghệ sáng tạo uy tín hàng đầu.
                    Chúng tôi không chỉ là đối tác, mà là người bạn đồng hành tin cậy của doanh nghiệp trong hành trình xây dựng hình ảnh và phát triển thương hiệu.
                </p>
            </div>
        </div>

        <!-- Tầm nhìn - Sứ mệnh -->
        <div class="row mb-5">
            <div class="col-md-6">
                <h3 class="about-title mb-3">Tầm nhìn</h3>
                <p class="about-description">
                    Trở thành công ty truyền thông và công nghệ hàng đầu tại Việt Nam, tiên phong trong việc áp dụng các giải pháp sáng tạo, bền vững và hiệu quả, mang lại giá trị thật cho khách hàng và cộng đồng.
                </p>
            </div>
            <div class="col-md-6">
                <h3 class="about-title mb-3">Sứ mệnh</h3>
                <p class="about-description">
                    Giúp doanh nghiệp lan tỏa giá trị đến đúng khách hàng thông qua các chiến dịch truyền thông, quảng cáo đa kênh, giải pháp phần mềm và chiến lược thương hiệu toàn diện.
                </p>
            </div>
        </div>

        <!-- Giá trị cốt lõi -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="about-title text-center mb-4">Giá trị cốt lõi</h3>
                <ul class="about-description core-values text-muted">
                    <li><span class="highlight">Sáng tạo:</span> Luôn đổi mới, dẫn đầu xu hướng.</li>
                    <li><span class="highlight">Trách nhiệm:</span> Cam kết chất lượng trong từng dự án.</li>
                    <li><span class="highlight">Chính trực:</span> Minh bạch và trung thực trong mọi hoạt động.</li>
                    <li><span class="highlight">Khách hàng là trung tâm:</span> Đồng hành và phát triển cùng khách hàng.</li>
                    <li><span class="highlight">Hợp tác:</span> Tôn trọng và gắn kết nội bộ và đối tác.</li>
                </ul>
            </div>
        </div>

        <!-- Hình ảnh minh họa khác -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <img src="/images/our-team.jpg" alt="Đội ngũ BÌNH MINH" class="about-image">
            </div>
            <div class="col-md-6 mb-4">
                <img src="/images/workspace.jpg" alt="Văn phòng sáng tạo" class="about-image">
            </div>
        </div>

        <!-- Cam kết -->
        <div class="row">
            <div class="col-12">
                <h3 class="about-title text-center mb-3">Cam kết của chúng tôi</h3>
                <p class="about-description text-muted text-center">
                    BÌNH MINH cam kết luôn đồng hành cùng khách hàng trên hành trình phát triển thương hiệu,
                    mang lại hiệu quả thực tế thông qua giải pháp toàn diện, bền vững và mang tính ứng dụng cao.
                </p>
            </div>
        </div>
    </div>
@endsection
