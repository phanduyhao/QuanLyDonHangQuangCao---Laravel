@extends('layout.mainAdmin')
@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{ $title }}</h3>
        <div>
            <form class="form-search" method="GET" action="{{ route('services.index') }}">
                <div class="mb-3 row">
                    <div class="col-lg-4 col-md-6 mb-2">
                        <input class="form-control shadow-none" type="text" name="search_name" placeholder="ID dịch vụ..."
                            value="{{ request('search_id') }}">
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <input class="form-control shadow-none" type="text" name="search_name"
                            placeholder="Tên dịch vụ..." value="{{ request('search_name') }}">
                    </div>
                    <div class="col-lg-4 col-md-6 mb-2">
                        <select name="search_status" class="form-control shadow-none">
                            <option value="">-- Trạng thái --</option>
                            <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Hoạt động
                            </option>
                            <option value="inactive" {{ request('search_status') == 'inactive' ? 'selected' : '' }}>Không
                                hoạt động</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <button type="submit" class="btn btn-danger">Tìm kiếm</button>
                        <a href="{{ route('services.index') }}" class="btn btn-secondary ms-2">Xóa lọc</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="d-flex p-4 justify-content-between">
                <h5 class=" fw-bold">Danh sách dịch vụ </h5>
                <button type="button" data-id="" class="btn btn-success text-dark px-2 py-1 fw-bolder"
                    data-bs-toggle="modal" data-bs-target="#createservice">Thêm mới</button>

            </div>
            <div class="modal fade" id="createservice" tabindex="-1" aria-labelledby="createserviceLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="createServiceLabel">Thêm mới dịch vụ</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body">
                            <div class="error">
                                @include('layout.error')
                            </div>
                            <form id="form_service_store" class="form-create" method="POST" enctype="multipart/form-data"
                                action="{{ route('services.store') }}">
                                @csrf
                                <div class="mb-3 d-flex flex-column image-gallery" id="image-gallery-form_service_store">
                                    <label class='form-label' for='service_image'>Ảnh đại diện</label>
                                    <input type="file" name="image" class="file-input"
                                        id="file-input-form_service_store"
                                        onchange="previewImages(event, 'form_service_store')">
                                    <div class="image-preview" id="image-preview-form_service_store"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="service_name">Tên dịch vụ</label>
                                    <input type="text" class="form-control input-field" id="service_name"
                                        name="service_name" data-require="Mời nhập Tên dịch vụ"
                                        placeholder="Nhập tên dịch vụ" value="{{ old('service_name') }}" />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="description">Mô tả</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Nhập mô tả dịch vụ"
                                        data-require="Mời nhập mô tả">{{ old('description') }}</textarea>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="pricing_model">Mô hình định giá</label>
                                        <select class="form-select" id="pricing_model" name="pricing_model" required>
                                            <option value="package" selected>Gói quảng cáo (Cố định)</option>
                                            <option value="cpc">Trả theo click (CPC)</option>
                                            <option value="cpm">Trả theo nghìn hiển thị (CPM)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3" id="packageFields">
                                        <div class="mb-3">
                                            <label class="form-label" for="package_price">Giá gói (VNĐ)</label>
                                            <input type="number" step="0.01" class="form-control" id="package_price"
                                                name="package_price" placeholder="Nhập giá gói"
                                                value="{{ old('package_price') }}" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="package_duration_days">Thời gian chạy
                                                (ngày)</label>
                                            <input type="number" class="form-control" id="package_duration_days"
                                                name="package_duration_days" placeholder="Nhập số ngày"
                                                value="{{ old('package_duration_days') }}" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="impressions_per_day">Lượt tiếp cận/ngày (ước
                                                tính)</label>
                                            <input type="number" class="form-control" id="impressions_per_day"
                                                name="impressions_per_day" placeholder="Nhập số lượt"
                                                value="{{ old('impressions_per_day') }}" />
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="mb-3">
                                    <label class="form-label" for="status">Trạng thái</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="active" selected>Kích hoạt</option>
                                        <option value="inactive">Ngừng kích hoạt</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success fw-semibold text-dark">Thêm mới</button>
                                    <button type="button" class="btn btn-secondary fw-semibold"
                                        data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên dịch vụ</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Thời gian tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($services as $service)
                            <tr @if ($service->status == 'inactive') class="text-danger" @endif
                                data-id="{{ $service->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img width="100"
                                        src="{{ $service->image ? '/images/services/' . $service->image : '/images/default-service.png' }}"
                                        alt="{{ $service->service_name }}'s Thumb" class="img-thumbnail">
                                </td>
                                <td class="fw-semibold">{{ $service->service_name }}</td>
                                <td>{{ Str::limit($service->description, 50) }}{{ $service->description && strlen($service->description) > 50 ? '...' : '' }}
                                </td>
                                <td>

                                    @if ($service->status === 'active')
                                        <span class="badge bg-success">Kích hoạt</span>
                                    @else
                                        <span class="badge bg-secondary">Ngừng kích hoạt</span>
                                    @endif
                                </td>
                                <td>{{ $service->created_at->format('d/m/Y H:i:s') }}</td>
                                <td class="">
                                    <!-- Nút Xóa -->
                                    <button type="button" data-url="{{ route('services.destroy', $service->id) }}"
                                        data-id="{{ $service->id }}"
                                        class="btn btn-danger btnDeleteAsk px-2 me-2 py-1 fw-bolder"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $service->id }}">Xóa</button>
                                    <!-- Nút Sửa -->
                                    <button type="button" data-id="{{ $service->id }}"
                                        class="btn btn-edit btnEditService btn-info text-dark px-2 py-1 fw-bolder">Sửa</button>
                                </td>
                            </tr>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1"
                                aria-labelledby="deleteModal{{ $service->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-wrap"
                                                id="deleteModal{{ $service->id }}Label">Bạn có chắc chắn xóa dịch vụ
                                                <b><u>{{ $service->service_name }}</u></b> không ?
                                            </h1>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="delete-forever btn btn-danger"
                                                data-id="{{ $service->id }}">Xóa</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-danger" id="editServiceModalLabel">Chỉnh sửa dịch vụ</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="card-body">
                                <div class="error">
                                    @include('layout.error')
                                </div>
                                <form method="POST" action="{{ route('services.update', ':id') }}"
                                    enctype="multipart/form-data" class="editServiceForm form-edit"
                                    id="form_service_update">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="id" id="service_id_edit">
                                    <input type="hidden" name="_method" value="PATCH">

                                    <div class="mb-3 d-flex flex-column image-gallery" id="image-gallery-edit">
                                        <label class="form-label" for="image_edit">Ảnh đại diện (nếu muốn thay
                                            đổi)</label>
                                        <input type="file" name="image" class="file-input" id="image_edit"
                                            accept="image/*">
                                        <div class="image-preview mt-2" id="image-preview-edit"></div>
                                    </div>

                                    <div class='mb-3'>
                                        <label class='form-label' for='service_name_edit'>Tên dịch vụ</label>
                                        <input type='text' class='form-control input-field' id='service_name_edit'
                                            placeholder='Nhập tên dịch vụ' name='service_name'
                                            data-require='Mời nhập tên dịch vụ' />
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label' for='description_edit'>Mô tả</label>
                                        <textarea class='form-control' id='description_edit' name='description' rows="3"
                                            placeholder='Nhập mô tả dịch vụ' data-require='Mời nhập mô tả'></textarea>
                                    </div>
                                    {{-- <div class='row'>
                                        <div class="col-md-6 mb-3">
                                            <label class='form-label' for='pricing_model_edit'>Mô hình định giá</label>
                                            <select class="form-select" id="pricing_model_edit" name="pricing_model"
                                                required>
                                                <option value="package">Gói quảng cáo (Cố định)</option>
                                                <option value="cpc">Trả theo click (CPC)</option>
                                                <option value="cpm">Trả theo nghìn hiển thị (CPM)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="mb-3">
                                                <label class='form-label' for='package_price_edit'>Giá gói (VNĐ)</label>
                                                <input type='number' step="0.01" class='form-control input-field'
                                                    id='package_price_edit' name="package_price"
                                                    placeholder="Nhập giá gói" />
                                            </div>
                                            <div class="mb-3">
                                                <label class='form-label' for='impressions_per_day_edit'>Lượt tiếp
                                                    cận/ngày (ước tính)</label>
                                                <input type='number' class='form-control input-field'
                                                    id='impressions_per_day_edit' name="impressions_per_day"
                                                    placeholder="Nhập số lượt" />
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="mb-3">
                                        <label class="form-label text-danger" for="status_edit">Trạng thái</label>
                                        <select name="status" class="form-control" id="status_edit">
                                            <option value="active">Kích hoạt</option>
                                            <option value="inactive">Ngừng kích hoạt</option>
                                        </select>
                                    </div>

                                    <div class="modal-footer">
                                        <button type='submit' class='btn btn-success fw-semibold text-dark'>Cập
                                            nhật</button>
                                        <button type="button" class="btn btn-secondary fw-semibold"
                                            data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pagination mt-4 pb-4">
                    {{ $services->links() }}
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btnEditService').on('click', function() {
                var serviceID = $(this).data('id');
                const editModal = $('#editServiceModal');
                // Gửi yêu cầu AJAX để lấy thông tin dịch vụ
                $.ajax({
                    url: '{{ route('services.show', ':id') }}'.replace(':id', serviceID),
                    type: 'GET',
                    success: function(response) {
                        // Cập nhật các trường dữ liệu vào form
                        $('#service_id_edit').val(response.id);
                        $('#service_name_edit').val(response.service_name);
                        $('#description_edit').val(response.description);
                        // $('#pricing_model_edit').val(response.pricing_model);
                        // $('#package_price_edit').val(response.package_price);
                        // $('#package_duration_days_edit').val(response.package_duration_days);
                        // $('#impressions_per_day_edit').val(response.impressions_per_day);
                        $('#status_edit').val(response.status);

                        // Cập nhật URL của form
                        $('#form_service_update').attr('action',
                            '{{ route('services.update', ':id') }}'.replace(':id',
                                serviceID));

                        // Hiển thị ảnh đại diện (nếu có)
                        var previewContainer = $('#image-preview-edit');
                        previewContainer.empty();
                        if (response.image) {
                            var imgElement = $('<img>').attr('src', '/images/services/' +
                                response.image).css('max-width', '200px');
                            previewContainer.append(imgElement);
                        }

                        // Cập nhật tiêu đề modal
                        document.getElementById('editServiceModalLabel').textContent =
                            'Chỉnh sửa dịch vụ: ' + response.service_name;

                        // Hiển thị modal
                        editModal.modal('show');
                    },
                    error: function() {
                        alert('Không thể lấy dữ liệu dịch vụ!');
                    }
                });
            });

            // Xử lý preview ảnh khi chọn file mới
            $('#image_edit').on('change', function(event) {
                const input = event.target;
                const previewContainer = $('#image-preview-edit');
                previewContainer.empty(); // Xóa ảnh cũ
                if (input.files && input.files.length > 0) {
                    for (let i = 0; i < input.files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $('<img>')
                                .attr('src', e.target.result)
                                .css('max-width', '200px')
                                .css('margin-right', '10px');
                            previewContainer.append(img);
                        };
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            });
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //     const pricingModelSelect = document.getElementById('pricing_model');
        //     const packageFields = document.getElementById('packageFields');

        //     pricingModelSelect.addEventListener('change', function() {
        //         if (this.value === 'package') {
        //             packageFields.style.display = 'block';
        //         } else {
        //             packageFields.style.display = 'none';
        //         }
        //     });
        // });
    </script>
@endsection
