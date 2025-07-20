@extends('layout.mainAdmin')
@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">Quản lý Bảng giá dịch vụ</h3>

        {{-- FORM TÌM KIẾM --}}
        <form class="form-search mb-4" method="GET" action="{{ route('servicesPricing.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <input class="form-control" name="search_service" placeholder="Tên dịch vụ..."
                        value="{{ request('search_service') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    <a href="{{ route('servicesPricing.index') }}" class="btn btn-secondary ms-2">Xóa lọc</a>
                </div>
            </div>
        </form>

        {{-- NÚT THÊM --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="fw-bold">Danh sách bảng giá</h5>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createPricingModal">Thêm
                    mới</button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên gói</th>
                            <th>Dịch vụ</th>
                            <th>Giá (VNĐ)</th>
                            <th>Số ngày</th>
                            <th>Lượt tiếp cận/ngày</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pricings as $index => $pricing)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pricing->title }}</td>
                                <td>{{ $pricing->service->service_name ?? 'N/A' }}</td>
                                <td>{{ number_format($pricing->price, 0, ',', '.') }}</td>
                                <td>
                                    @if ($pricing->duration_days)
                                        {{ $pricing->duration_days }} ngày
                                        @else
                                        Ngày tự do
                                    @endif
                                </td>
                                <td>{{ number_format($pricing->impressions_per_day) }} lượt</td>
                                <td>{{ $pricing->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm editBtn" data-id="{{ $pricing->id }}"
                                        data-service_id="{{ $pricing->service_id }}" data-price="{{ $pricing->price }}"
                                        data-duration="{{ $pricing->duration_days }}"
                                        data-impressions="{{ $pricing->impressions_per_day }}" data-bs-toggle="modal"
                                        data-bs-target="#editPricingModal">
                                        Sửa
                                    </button>
                                    <form method="POST" action="{{ route('servicesPricing.destroy', $pricing->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Bạn có chắc muốn xóa?')"
                                            class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $pricings->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL THÊM --}}
    <div class="modal fade" id="createPricingModal" tabindex="-1" aria-labelledby="createPricingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('servicesPricing.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm bảng giá mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Tên gói</label>
                            <input type="text" name="title" class="form-control" placeholder="VD: Gói Tuần" required>
                        </div>
                        <div class="mb-3">
                            <label>Dịch vụ</label>
                            <select name="service_id" class="form-control" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Giá (VNĐ)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Số ngày</label>
                            <input type="number" name="duration_days" class="form-control"
                                placeholder="Nhập nếu là gói Tuần/ Tháng/ Năm" required>
                        </div>
                        <div class="mb-3">
                            <label>Lượt tiếp cận/ngày</label>
                            <input type="number" name="impressions_per_day" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL SỬA --}}
    <div class="modal fade" id="editPricingModal" tabindex="-1" aria-labelledby="editPricingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editPricingForm">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật bảng giá</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label>Tên gói</label>
                            <input type="text" name="title" id="edit_title" class="form-control"
                                placeholder="VD: Gói Tuần" required>
                        </div>
                        <div class="mb-3">
                            <label>Dịch vụ</label>
                            <select name="service_id" id="edit_service_id" class="form-control" required>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->service_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Giá (VNĐ)</label>
                            <input type="number" name="price" id="edit_price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Số ngày</label>
                            <input type="number" name="duration_days" id="edit_duration" class="form-control"
                                placeholder="Nhập nếu là gói Tuần/ Tháng/ Năm" required>
                        </div>
                        <div class="mb-3">
                            <label>Lượt tiếp cận/ngày</label>
                            <input type="number" name="impressions_per_day" id="edit_impressions" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- JS: Đổ dữ liệu vào form sửa --}}
    <script>
        $(document).ready(function() {
            $('.editBtn').on('click', function() {
                const id = $(this).data('id');
                const modal = $('#editPricingModal');

                // Gọi AJAX để lấy dữ liệu từ Controller show()
                $.ajax({
                    url: '{{ route('servicesPricing.show', ':id') }}'.replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        // Đổ dữ liệu vào các field
                        $('#edit_id').val(response.id);
                        $('#edit_service_id').val(response.service_id);
                        $('#edit_title').val(response.title);
                        $('#edit_price').val(response.price);
                        $('#edit_duration').val(response.duration_days);
                        $('#edit_impressions').val(response.impressions_per_day);

                        // Cập nhật action của form
                        $('#editPricingForm').attr('action',
                            '{{ route('servicesPricing.update', ':id') }}'.replace(':id',
                                response.id));

                        // Cập nhật tiêu đề nếu muốn
                        $('#editPricingModalLabel').text('Chỉnh sửa bảng giá ID: ' + response
                            .id);

                        // Hiển thị modal
                        modal.modal('show');
                    },
                    error: function() {
                        alert('Không thể lấy thông tin bảng giá!');
                    }
                });
            });
        });
    </script>
@endsection
