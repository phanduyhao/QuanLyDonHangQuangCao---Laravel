@extends('layout.main')

@section('contents')
    <style>
        .image-thumbnail {
            aspect-ratio: 1.5;
            height: auto;
            width: 100%;
            object-fit: cover;
        }

        .object-fit-contain {
            object-fit: contain;
        }

        .card {
            border: 2px solid #c5c5c5 !important;
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

    <div class="content-wrapper py-4 px-3 rounded">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12 mb-4 text-center">
                    <div class="bg-label-success rounded-3 p-3">
                        <h4 class="fw-bold text-primary">Dịch vụ quảng cáo của chúng tôi</h4>
                        <p class="text-dark mb-0">Chọn loại hình dịch vụ phù hợp nhất để quảng bá thương hiệu của bạn</p>
                    </div>
                </div>

                @foreach ($services as $service)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4 text-center">
                            <div class="card-body">
                                <!-- Nếu có ảnh, hiển thị, nếu không hiển thị ảnh mặc định -->
                                <img src="{{ $service->image ? '/images/services/' . $service->image : '/images/default-service.png' }}"
                                    alt="{{ $service->service_name }}" width="100" height="100"
                                    class="mb-3  object-fit-contain mx-auto ">

                                <h5 class="fw-semibold text-dark">{{ $service->service_name }}</h5>
                                <p class="text-muted small">{{ Str::limit($service->description, 100) }}</p>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <button type="button" class="btn btn-success btn-sm rounded-pill"
                                        data-bs-toggle="modal" data-bs-target="#orderServiceModal"
                                        data-service-id="{{ $service->id }}"
                                        data-service-name="{{ $service->service_name }}">
                                        Đặt dịch vụ
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Modal đặt hàng quảng cáo -->
    <div class="modal fade" id="orderServiceModal" tabindex="-1" aria-labelledby="orderServiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title border-bottom" id="orderServiceModalLabel">Dịch vụ: </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <!-- Ẩn ID của dịch vụ được chọn -->
                        <input type="hidden" name="service_id" id="selectedServiceId" value="">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="packageSelect" class="form-label fw-bold">Chọn gói quảng cáo</label>
                                    <select class="form-select" id="packageSelect" name="package_id" required>
                                        <option value="" selected disabled>--- Chọn một gói ---</option>
                                    </select>
                                </div>
                            </div>
                            <div class="">
                                <div class="mb-3">
                                    <label for="campaignName" class="form-label fw-bold">Tên chiến dịch (tùy chọn)</label>
                                    <input type="text" class="form-control" id="campaignName" name="campaign_name"
                                        placeholder="Nhập tên cho chiến dịch của bạn" required>
                                </div>
                            </div>
                            <div class="">
                                <div class="mb-3">
                                    <label for="orderContent" class="form-label fw-bold">Nội dung quảng cáo</label>
                                    <textarea class="form-control" id="orderContent" name="content" rows="3"
                                        placeholder="Nhập nội dung chi tiết cho quảng cáo của bạn..." required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label fw-bold">Thời gian bắt đầu</label>
                                    <input type="date" class="form-control" id="startDate" name="start_date" required
                                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endDate" class="form-label fw-bold">Thời gian kết thúc</label>
                                    <input type="date" class="form-control" id="endDate" name="end_date" required>
                                </div>
                            </div>
<input type="hidden" name="reach_total" id="reachTotal">
                        </div>

                    </form>
                    <div id="summaryBox" class="alert alert-info">
                        <h6 class="fw-bold mb-2">Thông tin đơn hàng:</h6>
                        <p><strong>Tên gói:</strong> <span id="summaryPackageName"></span></p>
                        <p><strong>Số ngày:</strong>
                            <span id="summaryDuration"></span> ngày
                            (<span id="summaryDateRange"></span>)
                        </p>
                        <p><strong>Tổng giá:</strong> <span id="summaryPrice"></span> VNĐ</p>
                        <p><strong>Lượt tiếp cận:</strong> <span id="summaryReach"></span> lượt/ngày</p>
                        <p><strong>Tổng lượt tiếp cận ước tính:</strong> <span id="totalReach"></span> lượt</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="orderForm" class="btn btn-primary">Gửi đơn hàng</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderButtons = document.querySelectorAll('[data-bs-target="#orderServiceModal"]');
            const packageSelect = document.getElementById('packageSelect');
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');

            // Định dạng tiền tệ
            function number_format(number, decimals, dec_point, thousands_sep) {
                number = parseFloat(number).toFixed(decimals);
                const parts = number.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
                return parts.join(dec_point);
            }

            function calculateEndDate() {
                const selectedOption = packageSelect.options[packageSelect.selectedIndex];
                const duration = selectedOption?.dataset?.duration;
                const startDate = startDateInput.value;

                // Nếu không có startDate hoặc không hợp lệ thì không làm gì cả
                if (!startDate || isNaN(new Date(startDate).getTime())) {
                    endDateInput.value = '';
                    return;
                }

                const start = new Date(startDate);
                console.log('Start Date:', start);
                if (duration) {
                    // Gói có số ngày cố định => tính tự động
                    start.setDate(start.getDate() + parseInt(duration));
                    endDateInput.value = start.toISOString().split('T')[0];
                    // endDateInput.readOnly = true;
                } else {
                    // Gói "ngày bất kỳ" => để user tự chọn endDate
                    endDateInput.value = '';
                    // endDateInput.readOnly = false;
                }
            }

            function updateSummaryBox() {
                const selectedOption = packageSelect.options[packageSelect.selectedIndex];
                if (!selectedOption || !selectedOption.value) return;

                const pricingText = selectedOption.textContent;
                const durationRaw = selectedOption.dataset.duration;
                const duration = parseInt(durationRaw);
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;

                const pricingTitle = pricingText.split('»')[0]?.replace('★', '').trim();
                const reachPerDay = parseInt(pricingText.match(/- (\d+)\/ngày/)?.[1] || '0');
                const priceStr = pricingText.match(/» ([\d.,]+) VNĐ/)?.[1] || '';
                const priceNumber = parseFloat(priceStr.replace(/\./g, '').replace(',', '.')) || 0;

                document.getElementById('summaryPackageName').textContent = pricingTitle;
                document.getElementById('summaryReach').textContent = reachPerDay.toLocaleString('vi-VN');

                if (!isNaN(duration)) {
                    // Gói cố định
                    document.getElementById('summaryDuration').textContent = duration;
                    document.getElementById('summaryPrice').textContent = priceStr;
                    document.getElementById('totalReach').textContent = (reachPerDay * duration).toLocaleString(
                        'vi-VN');
                    document.getElementById('reachTotal').value = (reachPerDay * duration).toLocaleString(
                        'vi-VN');
                    document.getElementById('summaryDateRange').textContent = startDate + ' - ' + endDateInput
                        .value;
                } else {
                    // Gói tùy chọn ngày
                    if (startDate && endDate) {
                        const start = new Date(startDate);
                        const end = new Date(endDate);
                        const days = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;

                        if (days > 0) {
                            const total = priceNumber * days;
                            document.getElementById('summaryDuration').textContent = days;
                            document.getElementById('summaryPrice').textContent = total.toLocaleString('vi-VN');
                            document.getElementById('totalReach').textContent = (reachPerDay * days).toLocaleString(
                                'vi-VN');
                            document.getElementById('reachTotal').value = (reachPerDay * days).toLocaleString(
                                'vi-VN');
                            document.getElementById('summaryDateRange').textContent = startDate + ' - ' + endDate;
                        } else {
                            document.getElementById('summaryDuration').textContent = 'Ngày không hợp lệ';
                            document.getElementById('summaryPrice').textContent = '–';
                            document.getElementById('totalReach').textContent = '–';
                            document.getElementById('summaryDateRange').textContent = '';
                        }
                    } else {
                        document.getElementById('summaryDuration').textContent = 'Chưa đủ ngày';
                        document.getElementById('summaryPrice').textContent = '–';
                        document.getElementById('totalReach').textContent = '–';
                        document.getElementById('summaryDateRange').textContent = '';
                    }
                }
            }

            // Khi chọn gói hoặc ngày => cập nhật lại ngày kết thúc và thông tin
            packageSelect.addEventListener('change', function() {
                calculateEndDate();
                updateSummaryBox();
            });

            startDateInput.addEventListener('change', function() {
                calculateEndDate();
                updateSummaryBox();
            });

            endDateInput.addEventListener('change', updateSummaryBox);

            // Xử lý mở modal
            orderButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const serviceID = this.getAttribute('data-service-id');
                    const serviceName = this.getAttribute('data-service-name');
                    document.getElementById('selectedServiceId').value = serviceID;
                    document.getElementById('orderServiceModalLabel').textContent = 'Dịch vụ: ' +
                        serviceName;

                    fetch(`/services/${serviceID}/pricings`)
                        .then(response => response.json())
                        .then(pricings => {
                            // Xóa option cũ
                            while (packageSelect.options.length > 1) {
                                packageSelect.remove(1);
                            }

                            // Thêm các option mới
                            pricings.forEach(pricing => {
                                const option = document.createElement('option');
                                option.value = pricing.id;
                                option.textContent =
                                    `★ ${pricing.title} » ${number_format(pricing.price, 0, ',', '.')} VNĐ (${pricing.duration_days ? pricing.duration_days + ' ngày' : 'Số ngày bất kì'} - ${pricing.impressions_per_day}/ngày)`;
                                option.dataset.duration = pricing.duration_days;
                                packageSelect.appendChild(option);
                            });

                            // Reset lại summary box
                            document.getElementById('summaryPackageName').textContent = '';
                            document.getElementById('summaryDuration').textContent = '';
                            document.getElementById('summaryPrice').textContent = '';
                            document.getElementById('summaryReach').textContent = '';
                            startDateInput.value = '';
                            endDateInput.value = '';
                            packageSelect.selectedIndex = 0;
                        })
                        .catch(error => {
                            console.error('Error fetching pricings:', error);
                        });
                });
            });
        });
    </script>
@endsection
