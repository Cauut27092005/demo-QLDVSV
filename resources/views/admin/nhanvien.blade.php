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

                    <th width="70">

                        STT

                    </th>

                    <th>

                        Mã NV

                    </th>

                    <th>

                        Họ tên

                    </th>

                    <th>

                        Bộ phận

                    </th>

                    <th>

                        Trạng thái

                    </th>

                    <th width="180">

                        Thao tác

                    </th>

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

                    <td>

                        <button

                            class="btn btn-warning btn-sm"

                            @click="editNV(item)">

                            <i class="fa-solid fa-pen"></i>

                            Sửa

                        </button>

                        <button

                            class="btn btn-danger btn-sm ms-2"

                            @click="deleteNV(item.MaNV)">

                            <i class="fa-solid fa-trash"></i>

                            Xóa

                        </button>

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

@include('admin.modal_nhanvien')