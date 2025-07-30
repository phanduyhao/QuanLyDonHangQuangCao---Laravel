@extends('layout.mainAdmin')

@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{ $title }}</h3>

        <!-- Tìm kiếm -->
        <div>
            <form class="form-search" method="GET" action="{{ route('admin.contacts.index') }}">
                <div class="d-flex align-items-center mb-4">
                    <h4 class="ten-game me-3 mb-0">Tìm kiếm liên hệ</h4>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_name"
                                placeholder="Tìm theo tên..." value="{{ request('search_name') }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_email"
                                placeholder="Tìm theo email..." value="{{ request('search_email') }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="text" name="search_phone"
                                placeholder="Tìm theo số điện thoại..." value="{{ request('search_phone') }}">
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <select class="form-control shadow-none" name="search_isRead">
                                <option value="">-- Trạng thái --</option>
                                <option value="0" {{ request('search_isRead') == '0' ? 'selected' : '' }}>Chưa đọc
                                </option>
                                <option value="1" {{ request('search_isRead') == '1' ? 'selected' : '' }}>Đã đọc
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="text-nowrap">
                                <button type="submit" class="btn btn-danger rounded-pill"><i
                                        class="fas fa-search me-2"></i>Tìm kiếm</button>
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary rounded-pill ms-2"><i
                                        class="fas fa-times me-2"></i>Xóa lọc</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danh sách liên hệ -->
        <div class="card">
            <div class="d-flex p-4 justify-content-between">
                <h5 class="fw-bold">Danh sách liên hệ</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Thời gian gửi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($contacts as $contact)
                            <tr @if (!$contact->isRead) class="fw-bold" @endif>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $contact->message }}</td>
                                <td>
                                    @if ($contact->isRead)
                                        <span class="badge bg-success">Đã đọc</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Chưa đọc</span>
                                    @endif
                                </td>
                                <td>{{ $contact->created_at->format('H:i d/m/Y') }}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-info btn-sm btn-contact-detail"
                                        data-id="{{ $contact->id }}">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có liên hệ nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Modal Chi tiết liên hệ -->
                <div class="modal fade" id="contactDetailModal" tabindex="-1" aria-labelledby="contactDetailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="contactDetailModalLabel">Chi tiết liên hệ</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body">
                                <div id="contact-detail-content">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Đang tải...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pagination mt-4 pb-4">
                    {{ $contacts->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const modal = new bootstrap.Modal(document.getElementById('contactDetailModal'));

                document.querySelectorAll('.btn-contact-detail').forEach(button => {
                    button.addEventListener('click', function() {
                        const contactId = this.getAttribute('data-id');
                        const contentDiv = document.getElementById('contact-detail-content');

                        contentDiv.innerHTML = `<div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>`;

                        fetch(`/admin/contacts/${contactId}`)
                            .then(res => {
                                if (!res.ok) throw new Error('Không tìm thấy liên hệ!');
                                return res.json();
                            })
                            .then(contact => {
                                document.getElementById('contactDetailModalLabel').textContent =
                                    `Chi tiết liên hệ #${contact.id}`;
                                contentDiv.innerHTML = `
                            <table class="table table-bordered text-dark fw-bold">
                                <tr><th>Họ tên</th><td>${contact.name}</td></tr>
                                <tr><th>Email</th><td>${contact.email}</td></tr>
                                <tr><th>Số điện thoại</th><td>${contact.phone ?? 'Không có'}</td></tr>
                                <tr><th>Nội dung</th><td>${contact.message}</td></tr>
                                <tr><th>Trạng thái</th><td>${contact.isRead ? '<span class="text-success">Đã đọc</span>' : '<span class="text-danger">Chưa đọc</span>'}</td></tr>
                                <tr><th>Thời gian gửi</th><td>${formatDate(contact.created_at)}</td></tr>
                            </table>
                        `;
                            })
                            .catch(err => {
                                contentDiv.innerHTML =
                                    `<div class="alert alert-danger">${err.message}</div>`;
                            });

                        modal.show();
                    });
                });
            });

            function formatDate(dateStr) {
                const date = new Date(dateStr);
                const d = date.getDate().toString().padStart(2, '0');
                const m = (date.getMonth() + 1).toString().padStart(2, '0');
                const y = date.getFullYear();
                const h = date.getHours().toString().padStart(2, '0');
                const min = date.getMinutes().toString().padStart(2, '0');
                return `${h}:${min} ${d}/${m}/${y}`;
            }
        </script>
@endsection
