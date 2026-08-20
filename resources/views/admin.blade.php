<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý nhân viên</title>
    @vite(['resources/css/admin.css',
    'resources/js/admin.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- Header -->
        <div class="header">
            <div class="title-area">
                <div class="title-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <h4 class="mb-0">
                        Quản lý nhân viên
                    </h4>
                    <small class="text-muted">
                        Danh sách nhân viên xử lý yêu cầu
                    </small>
                </div>
            </div>
            <a href="/logout" class="btn btn-danger">
                <i class="fa-solid fa-right-from-bracket"></i>
                Đăng xuất
            </a>
        </div>
        <!-- Content -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <button
                        class="btn btn-success"
                        @click="openAddNV">
                        <i class="fa-solid fa-plus"></i>
                        Thêm nhân viên
                    </button>
                </div>
            </div>
            <div
                class="alert alert-warning"
                v-if="googleChoDuyet.length">
                <h5>
                    Tài khoản Google chờ duyệt
                </h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Họ tên</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in googleChoDuyet"
                            :key="item.MaND">
                            <td>
                                @{{ item.Email }}
                            </td>
                            <td>
                                @{{ item.HoTen }}
                            </td>
                            <td>
                                <button
                                    class="btn btn-success btn-sm"
                                    @click="openGoogleModal(item)">
                                    Phê duyệt
                                </button>
                                <button
                                    class="btn btn-danger btn-sm"
                                    @click="tuChoi(item.MaND)">
                                    Từ chối
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <!-- Search -->
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input class="form-control"
                                placeholder="Tìm theo mã hoặc tên..."
                                v-model="searchNV">
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="70">STT</th>
                                <th>Mã NV</th>
                                <th>Họ tên</th>
                                <th>Email Google</th>
                                <th>Quầy</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th width="90" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item,index) in filterNV"
                                :key="item.MaNV">
                                <td>@{{ index+1 }}</td>
                                <td>@{{ item.MaNV }}</td>
                                <td>@{{ item.HoTen }}</td>
                                <td>
                                    <span v-if="item.Email">
                                        @{{ item.Email }}
                                    </span>

                                    <span
                                        v-else
                                        class="text-secondary">
                                        Chưa liên kết
                                    </span>
                                </td>

                                <td>@{{ item.Quay }}</td>
                                <td>
                                    <span class="badge bg-danger"
                                        v-if="item.VaiTro=='Admin'">
                                        Quản trị viên
                                    </span>
                                    <span class="badge bg-warning text-dark"
                                        v-else-if="item.VaiTro=='TruongPhong'">
                                        Trưởng phòng
                                    </span>
                                    <span class="badge bg-primary" v-else>
                                        Nhân viên
                                    </span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-success"
                                        v-if="item.TrangThai=='HoatDong'">
                                        Hoạt động
                                    </span>
                                    <span
                                        class="badge bg-warning text-dark"
                                        v-else-if="item.TrangThai=='ChoDuyet'">
                                        Chờ duyệt
                                    </span>
                                    <span
                                        class="badge bg-danger"
                                        v-else>
                                        Từ chối
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-sm"
                                            data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button
                                                    class="dropdown-item"
                                                    href="#"
                                                    @click.prevent="editNV(item)">
                                                    <i class="fa-solid fa-pen me-2"></i>
                                                    Sửa
                                                </button>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <button
                                                    class="dropdown-item text-danger"
                                                    href="#"
                                                    @click.prevent="deleteNV(item.MaNV)">
                                                    <i class="fa-solid fa-trash me-2"></i>
                                                    Xóa
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="nhanVienModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            v-text="isEdit ? 'Sửa nhân viên' : 'Thêm nhân viên'">
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-card">
                            <div v-if="!isEdit">
                                <label>Mã nhân viên</label>
                                <input class="form-control"
                                    v-model="formNV.MaNV">
                            </div>
                            <label>Tên người dùng</label>
                            <input class="form-control"
                                v-model="formNV.HoTen">
                            <label>Quầy</label>
                            <select
                                class="form-select"
                                v-model="formNV.Quay">
                                <option value="">Không có</option>
                                <option value="1">Quầy 1</option>
                                <option value="2">Quầy 2</option>
                                <option value="3">Quầy 3</option>
                                <option value="4">Quầy 4</option>
                                <option value="5">Quầy 5</option>
                                <option value="6">Quầy 6</option>
                            </select>
                            <label>Vai trò</label>
                            <select
                                class="form-select"
                                v-model="formNV.VaiTro">
                                <option value="Admin">Quản trị</option>
                                <option value="TruongPhong">Trưởng phòng</option>
                                <option value="NhanVien">Nhân viên</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Hủy
                        </button>
                        <button class="btn btn-success"
                            @click="saveNV">
                            Lưu
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade"
            id="googleModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Phê duyệt Google</h5>
                    </div>
                    <div class="modal-body">
                        <label>Mã nhân viên</label>
                        <select
                            class="form-select"
                            v-model="formGoogle.MaNV">
                            <option
                                v-for="nv in nhanViens"
                                :value="nv.MaNV">
                                @{{ nv.MaNV }}
                                -
                                @{{ nv.HoTen }}
                            </option>
                        </select>
                        <label class="mt-3">
                            Vai trò
                        </label>
                        <select
                            class="form-select"
                            v-model="formGoogle.VaiTro">
                            <option value="Admin">
                                Admin
                            </option>
                            <option value="TruongPhong">
                                Trưởng phòng
                            </option>
                            <option value="NhanVien">
                                Nhân viên
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Hủy
                        </button>
                        <button
                            class="btn btn-success"
                            @click="duyetGoogle">
                            Phê duyệt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>