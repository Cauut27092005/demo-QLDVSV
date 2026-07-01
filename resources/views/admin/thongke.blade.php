<div class="card shadow table-box tk-box">

    <div class="card-header tk-header text-white">
        <h5 class="mb-0">
            <i class="fa-solid fa-chart-line me-2"></i>
            Thống kê số yêu cầu đã xử lý
        </h5>
        <small>Báo cáo theo nhân viên và khoảng thời gian</small>
    </div>
    <div class="card-body">
        <!-- FILTER -->
        <div class="row mb-3 g-3">
            <div class="col-md-4">
                <label class="form-label">Từ ngày</label>
                <input type="date" class="form-control tk-input" v-model="tuNgay">
            </div>
            <div class="col-md-4">
                <label class="form-label">Đến ngày</label>
                <input type="date" class="form-control tk-input" v-model="denNgay">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100 tk-btn"
                    @click="loadThongKe()">
                    Thống kê
                </button>
            </div>
        </div>
        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table tk-table align-middle">
                <thead>
                    <tr>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Số hoàn thành</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in thongKePage" :key="item.MaNV">
                        <td><strong>@{{ item.MaNV }}</strong></td>
                        <td>@{{ item.HoTen }}</td>
                        <td>
                            <span class="tk-number">
                                @{{ item.SoLuong }}
                            </span>
                        </td>
                        <td>
                            <button type="button"
                                class="btn btn-primary btn-sm tk-detail-btn"
                                @click="xemChiTiet(item.MaNV)">
                                Chi tiết
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        <nav class="tk-pagination mt-3">
            <ul class="pagination justify-content-center">
                <li class="page-item"
                    :class="{disabled:currentPage.tk==1}">
                    <a class="page-link"
                        @click.prevent="changePage('tk',currentPage.tk-1)">
                        «
                    </a>
                </li>
                <li v-for="i in totalTKPage"
                    :key="i"
                    class="page-item"
                    :class="{active:i==currentPage.tk}">
                    <a class="page-link"
                        @click.prevent="changePage('tk',i)">
                        @{{ i }}
                    </a>
                </li>
                <li class="page-item"
                    :class="{disabled:currentPage.tk==totalTKPage}">
                    <a class="page-link"
                        @click.prevent="changePage('tk',currentPage.tk+1)">
                        »
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</div>
<div class="modal fade" id="chiTietModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content tk-modal">
            <div class="modal-header tk-modal-header text-white">
                <h5 class="modal-title">
                    Chi tiết nhân viên @{{ nhanVienDangXem }}
                </h5>
                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table tk-modal-table align-middle">
                        <thead>
                            <tr>
                                <th>Mã YC</th>
                                <th>Mã SV</th>
                                <th>Loại DV</th>
                                <th>Ngày gửi</th>
                                <th>Ngày hoàn thành</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in chiTietNV" :key="item.MaYC">
                                <td><strong>@{{ item.MaYC }}</strong></td>
                                <td>@{{ item.MaSV }}</td>
                                <td>@{{ item.LoaiDichVu }}</td>
                                <td>@{{ item.NgayGui }}</td>
                                <td>
                                    <span class="text-success fw-semibold">
                                        @{{ item.NgayHoanThanh }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>