@extends('layout.main')

@section('title', 'Liên hệ - Bình Minh')

@section('contents')
    <div class="container py-5">
        <h2 class="text-center text-primary mb-5 fw-bold">Liên hệ với chúng tôi</h2>

        <!-- Google Map -->
        <div class="row mt-5">
            <div class="col-12">
                <h5 class="text-center text-dark mb-3">Bản đồ</h5>
                <div class="ratio ratio-16x9 rounded shadow-sm overflow-hidden" style="height: 450px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.313507351722!2d105.8273875256979!3d10.073377471766438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a07d207d91042f%3A0xa4ad0d975c4b555c!2z4bqkcCBUaHXhuq1uIFRp4bq_biwgVGh14bqtbiBBbiwgVGjhu4sgeMOjIELDrG5oIE1pbmgsIFbEqW5oIExvbmcsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1753889294720!5m2!1svi!2s"
                        width="600" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <!-- Thông tin liên hệ -->
            <div class="col-md-5">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <h5 class="mb-3 text-dark">Thông tin công ty</h5>
                    <p><i class="bx bx-map me-2"></i><strong>Địa chỉ:</strong><br>
                        Số 0627A tổ 33, ấp Thuận Tiến A, Xã Thuận An, TX Bình Minh, Vĩnh Long
                    </p>
                    <p><i class="bx bx-phone me-2"></i><strong>Điện thoại:</strong><br>
                        0270 3892081 – 0939 226 ***
                    </p>
                    <p><i class="bx bx-envelope me-2"></i><strong>Email:</strong><br>
                        <a href="mailto:binhminhads@gmail.com" class="text-decoration-none">binhminhads@gmail.com</a>
                    </p>
                    <p><i class="bx bx-user me-2"></i><strong>Người đại diện:</strong><br>
                        ĐỖ HỒNG THẮM
                    </p>
                    <p><i class="bx bx-globe me-2"></i><strong>Tên quốc tế:</strong><br>
                        Binh Minh Advertising Trading Company Limited
                    </p>
                </div>
            </div>

            <!-- Form liên hệ -->
            <div class="col-md-7">
                <!-- Hiển thị thông báo thành công -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                <!-- Hiển thị lỗi validate -->
                @if ($errors->any())
                    <div class="alert alert-danger mtt-3">
                        <strong>Đã xảy ra lỗi:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <h5 class="mb-3 text-dark">Gửi tin nhắn cho chúng tôi</h5>
                    <form action="{{ route('submit.contact') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Họ tên</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Điện thoại</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Nội dung</label>
                            <textarea name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
