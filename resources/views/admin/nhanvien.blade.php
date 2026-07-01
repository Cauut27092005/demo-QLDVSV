<div class="card table-box">
    <div class="card-header">
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
        <button
            class="btn btn-success"
            @click="openAddNV">
            <i class="fa-solid fa-plus"></i>
            Thêm nhân viên
        </button>
    </div>
    <div class="card-body">
        <!-- Search -->
        <div class="row mb-4">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input
                        class="form-control"
                        placeholder="Tìm theo mã hoặc tên..."
                        v-model="searchNV">
                </div>
            </div>
        </div>
        <table class="table align-middle">
            <thead>
                <tr>
                    <th width="70">STT</th>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Bộ phận</th>
                    <th>Trạng thái</th>
                    <th width="120" class="text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item,index) in nhanVienPage"
                    :key="item.MaNV">
                    <td>
                        @{{ (currentPage.nv-1)*pageSize+index+1 }}
                    </td>
                    <td>
                        <strong>
                            @{{ item.MaNV }}
                        </strong>
                    </td>
                    <td>
                        @{{ item.HoTen }}
                    </td>
                    <td>
                        <span class="badge bg-info">
                            @{{ item.BoPhan }}
                        </span>
                    </td>
                    <td>
                        <span
                            v-if="item.TrangThaiOnline==1"
                            class="badge bg-success">
                            Online
                        </span>
                        <span
                            v-else
                            class="badge bg-secondary">
                            Offline
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                            <button
                                class="btn btn-outline-secondary btn-sm"
                                type="button"
                                data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click.prevent="editNV(item)">
                                        <i class="fa-solid fa-pen me-2"></i>
                                        Sửa
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        @click.prevent="resetPassword(item.MaNV)">
                                        <i class="fa-solid fa-key me-2"></i>
                                        Reset mật khẩu
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item text-danger"
                                        href="#"
                                        @click.prevent="deleteNV(item.MaNV)">
                                        <i class="fa-solid fa-trash me-2"></i>
                                        Xóa
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-end">
                <li
                    class="page-item"
                    :class="{disabled:currentPage.nv==1}">
                    <a
                        class="page-link"
                        href="#"
                        @click.prevent="changePage('nv',currentPage.nv-1)">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
                <li
                    class="page-item"
                    v-for="i in totalNVPage"
                    :class="{active:i==currentPage.nv}">
                    <a
                        class="page-link"
                        href="#"
                        @click.prevent="changePage('nv',i)">
                        @{{ i }}
                    </a>
                </li>
                <li
                    class="page-item"
                    :class="{disabled:currentPage.nv==totalNVPage}">
                    <a
                        class="page-link"
                        href="#"
                        @click.prevent="changePage('nv',currentPage.nv+1)">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@include('admin.modal_nhanvien')