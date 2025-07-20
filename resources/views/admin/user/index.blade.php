@extends('layout.mainAdmin')
@section('contents')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold text-primary py-3 mb-4">{{ $title }}</h3>
        <div>
            <form class="form-search" method="GET" action="{{ route('users.index') }}">
                @csrf
                <div class="d-flex align-items-center mb-4">
                    <h4 class="ten-game me-3 mb-0">Tìm kiếm</h4>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <input class="form-control shadow-none" type="number" name="search_id"
                                placeholder="Tìm theo mã số..." value="{{ request('search_id') }}">
                        </div>
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
                        <!-- Thêm dưới các ô input hiện tại -->
                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <select class="form-control shadow-none" name="search_role">
                                <option value="">-- Chọn vai trò --</option>
                                <option value="admin" {{ request('search_role') == 'admin' ? 'selected' : '' }}>Quản trị
                                </option>
                                <option value="user" {{ request('search_role') == 'user' ? 'selected' : '' }}>Người dùng
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <select class="form-control shadow-none" name="search_status">
                                <option value="">-- Trạng thái tài khoản --</option>
                                <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Hoạt
                                    động</option>
                                <option value="inactive" {{ request('search_status') == 'inactive' ? 'selected' : '' }}>Khóa
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12 mb-3">
                            <div class="text-nowrap">
                                <button type="submit" class="btn btn-danger rounded-pill"><i
                                        class="fas fa-search me-2"></i>Tìm kiếm</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-pill ms-2"><i
                                        class="fas fa-times me-2"></i>Xóa lọc</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="d-flex p-4 justify-content-between">
                <h5 class=" fw-bold">Tài khoản quản trị </h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID Người dùng</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Quyền</th>
                            <th>Thời gian tạo</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $user)
                            <tr @if ($user->status == 'inactive') class="text-danger" @endif data-id="{{ $user->id }}">
                                <td> {{ $loop->iteration }}</td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->status == 'active' ? 'Hoạt động' : 'Bị khóa' }}</td>
                                <td>{{ $user->role == 'user' ? 'Người dùng' : 'Người quản trị' }}</td>
                                <td>{{ $user->updated_at }}</td>
                                @if (Auth::user()->role == 'admin')
                                    <td class="">
                                        <button type="button" data-url="/users/{{ $user->id }}"
                                            data-id="{{ $user->id }}"
                                            class="btn btn-danger btnDeleteAsk px-2 me-2 py-1 fw-bolder"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}">Xóa</button>
                                        <button type="button" data-id="{{ $user->id }}"
                                            class="btn btn-edit btnEditUser btn-info text-dark px-2 py-1 fw-bolder">Sửa</button>
                                    </td>
                                @endif

                                <!-- Modal Delete -->
                                <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="deleteModal{{ $user->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5 text-wrap"
                                                    id="deleteModal{{ $user->id }}Label">Bạn có chắc chắn xóa người
                                                    dùng <b><u>{{ $user->name }}</u></b> không ?</h1>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="delete-forever btn btn-danger"
                                                    data-id="{{ $user->id }}">Xóa</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="modal fade ModelEditUser" id="editUser" tabindex="-1" aria-labelledby="editUserLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 text-danger" id="createUserLabel"> </h1>
                            </div>
                            <div class="card-body">
                                <form method='post' action='' enctype="multipart/form-data"
                                    class="editUserForm form-edit" id="form_userAdmin_update">
                                    @method('PATCH')
                                    @csrf
                                    <div class='mb-3'>
                                        <label class='form-label' for='basic-default-fullname'>Họ tên</label>
                                        <input type='text' class='form-control name input-field ' id='name-edit'
                                            placeholder='Nhập họ tên' name='name' data-require='Mời nhập họ tên' />
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label' for='basic-default-company'>Email</label>
                                        <input type='email' class='form-control email input-field' id='email-edit'
                                            placeholder='Nhập Email' name='email' data-require='Mời nhập email' />
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label' for='basic-default-company'>Số điện thoại</label>
                                        <input type='phone' class='form-control phone input-field' id='phone-edit'
                                            placeholder='Nhập số điện thoại' name='phone'
                                            data-require='Mời nhập số điện thoại' />
                                    </div>
                                    <div class='mb-3'>
                                        <label class='form-label' for='basic-default-company'>Mật khẩu</label>
                                        <input type='text' class='form-control password' id='password-edit'
                                            placeholder='********' name='password' />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-danger" for="status_user">Trạng thái tài
                                            khoản</label>
                                        <select name="status_user" class="form-control" id="status_user">
                                            <option value="active">Hoạt động</option>
                                            <option value="inactive">Khóa</option>
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
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.btnEditUser').on('click', function() {
                var userID = $(this).data('id'); // Lấy ID từ nút Sửa
                const ModelEdit = $('.ModelEditUser');
                const editUser = ModelEdit.attr('id', 'editUser' + userID);
                const IdEditUser = editUser.attr('id');

                $.ajax({
                    url: 'users/' + userID, // URL API để lấy thông tin người dùng
                    type: 'GET',
                    success: function(response) {
                        // Cập nhật các trường dữ liệu trong modal
                        $('#' + IdEditUser + ' #name-edit').val(response.name);
                        $('#' + IdEditUser + ' .modal-title').text('Chỉnh sửa người dùng: ' +
                            response.name);
                        $('#' + IdEditUser + ' #email-edit').val(response.email);
                        $('#' + IdEditUser + ' #phone-edit').val(response.phone);
                        $('#' + IdEditUser + ' #password-edit').val('');
                        $('#' + IdEditUser + ' #role-edit').val(response.role);
                        const statusValue = response.active === 'active' ? 'active' :
                        'inactive';

                        $('#' + IdEditUser + ' #status_user').val(statusValue);

                        $('#form_userAdmin_update').attr('action', 'users/' +
                            userID); // Cập nhật URL của form để sử dụng cho việc cập nhật
                        $(editUser).modal('show'); // Hiển thị modal
                    },
                    error: function() {
                        alert('Không thể lấy dữ liệu người dùng!');
                    }
                });
            });

        });
    </script>
@endsection
