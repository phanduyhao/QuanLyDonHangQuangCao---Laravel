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

        .banner-about {
            aspect-ratio: 1.5;
            height: auto;
            object-fit: cover;
        }

        li,
        p {
            color: black;
        }
    </style>
    <div id="heroBanner" class="container carousel slide mt-3" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/images/banner/banner1.jpg" class="d-block w-100 img-banner" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="/images/banner/banner2.jpg" class="d-block w-100 img-banner" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="/images/banner/banner3.jpg" class="d-block w-100 img-banner" alt="Banner 3">
            </div>
            <div class="carousel-item">
                <img src="/images/banner/banner4.png" class="d-block w-100 img-banner" alt="Banner 4">
            </div>
        </div>

        <!-- Điều hướng trái/phải -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroBanner" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroBanner" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Tiếp</span>
        </button>
    </div>
    <div class="container about-section px-5 bg-white mt-4">
        <!-- Giới thiệu chung -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="/images/about/banner7.png" alt="Giới thiệu Bình Minh"
                    class="about-image img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h2 class="about-title text-primary mb-3">Chúng tôi là BÌNH MINH</h2>
                <p class="about-description ">
                    Được thành lập với sứ mệnh <span class="highlight">“Thắp sáng thương hiệu Việt”</span>,
                    <strong>BÌNH MINH</strong> là đơn vị cung cấp dịch vụ quảng cáo, truyền thông và công nghệ sáng tạo uy
                    tín hàng đầu.
                    Chúng tôi không chỉ là đối tác, mà là người bạn đồng hành tin cậy của doanh nghiệp trong hành trình xây
                    dựng hình ảnh và phát triển thương hiệu.
                </p>
            </div>
        </div>

        <!-- Tầm nhìn - Sứ mệnh -->
        <div class="row mb-5">
            <div class="col-md-6">
                <h3 class="about-title mb-3">Tầm nhìn</h3>
                <img src="/images/about/banner2.jpg" alt="Tầm nhìn công ty"
                    class="img-fluid rounded mb-3 shadow-sm banner-about">
                <p class="about-description">
                    Trở thành công ty truyền thông và công nghệ hàng đầu tại Việt Nam, tiên phong trong việc áp dụng các
                    giải pháp sáng tạo, bền vững và hiệu quả, mang lại giá trị thật cho khách hàng và cộng đồng.
                </p>
            </div>
            <div class="col-md-6">
                <h3 class="about-title mb-3">Sứ mệnh</h3>
                <img src="/images/about/banner3.jpg" alt="Sứ mệnh công ty"
                    class="img-fluid rounded mb-3 shadow-sm banner-about">
                <p class="about-description">
                    Giúp doanh nghiệp lan tỏa giá trị đến đúng khách hàng thông qua các chiến dịch truyền thông, quảng cáo
                    đa kênh, giải pháp phần mềm và chiến lược thương hiệu toàn diện.
                </p>
            </div>
        </div>

        <!-- Giá trị cốt lõi -->
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="about-title text-center mb-4">Giá trị cốt lõi</h3>
                <div class="d-flex align-items-center">
                    <img src="/images/about/banner4.jpg" alt="Giá trị cốt lõi"
                        class="d-block mx-auto img-fluid rounded mb-4 shadow banner-about" style="max-width: 80%;">
                    <ul class="about-description core-values ">
                        <li><span class="highlight">Sáng tạo:</span> Luôn đổi mới, dẫn đầu xu hướng.</li>
                        <li><span class="highlight">Trách nhiệm:</span> Cam kết chất lượng trong từng dự án.</li>
                        <li><span class="highlight">Chính trực:</span> Minh bạch và trung thực trong mọi hoạt động.</li>
                        <li><span class="highlight">Khách hàng là trung tâm:</span> Đồng hành và phát triển cùng khách hàng.
                        </li>
                        <li><span class="highlight">Hợp tác:</span> Tôn trọng và gắn kết nội bộ và đối tác.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Hình ảnh minh họa khác -->
        <div class="row mb-5">
            <h3 class="about-title text-center mb-4">Văn phòng sáng tạo</h3>
            <div class="col-md-6 mb-4">
                <img src="/images/about/banner8.jpg" alt="Đội ngũ BÌNH MINH"
                    class="about-image img-fluid rounded shadow banner-about">
            </div>
            <div class="col-md-6 mb-4">
                <img src="/images/about/banner5.jpg" alt="Văn phòng sáng tạo"
                    class="about-image img-fluid rounded shadow banner-about">
            </div>
        </div>

        <!-- Cam kết -->
        <div class="row">
            <div class="col-12">
                <h3 class="about-title text-center mb-3">Cam kết của chúng tôi</h3>
                <img src="/images/about/banner6.jpg"
                    alt="Cam kết phát triển" class="d-block mx-auto img-fluid rounded mb-4 shadow banner-about" style="max-width: 75%;">
                <p class="about-description  text-center">
                    BÌNH MINH cam kết luôn đồng hành cùng khách hàng trên hành trình phát triển thương hiệu,
                    mang lại hiệu quả thực tế thông qua giải pháp toàn diện, bền vững và mang tính ứng dụng cao.
                </p>
            </div>
        </div>
    </div>

@endsection
