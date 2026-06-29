<div class="card shadow table-box">
    <div class="card-header bg-dark text-white">
        Thống kê số yêu cầu đã xử lý
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Từ ngày</label>
                <input
                    type="date"
                    class="form-control"
                    v-model="tuNgay">
            </div>
            <div class="col-md-4">
                <label>Đến ngày</label>
                <input
                    type="date"
                    class="form-control"
                    v-model="denNgay">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button
                    class="btn btn-primary w-100"
                    @click="loadThongKe()">
                    Thống kê
                </button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Số yêu cầu hoàn thành</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in thongKeNhanVien"
                    :key="item.MaNV">
                    <td>
                        <a href="#"
                            @click.prevent="xemChiTiet(item.MaNV)">
                            @{{ item.MaNV }}
                        </a>
                    </td>
                    <td>@{{ item.HoTen }}</td>
                    <td>
                        <span class="badge bg-success">
                            @{{ item.SoLuong }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                            @click="xemChiTiet(item.MaNV)">
                            Chi tiết
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Chi tiết nhân viên -->
<div class="modal fade" id="chiTietModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Chi tiết nhân viên @{{ nhanVienDangXem }}
                </h5>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại DV</th>
                            <th>Ngày gửi</th>
                            <th>Ngày hoàn thành</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in chiTietNV"
                            :key="item.MaYC">
                            <td>@{{ item.MaYC }}</td>
                            <td>@{{ item.MaSV }}</td>
                            <td>@{{ item.LoaiDichVu }}</td>
                            <td>@{{ item.NgayGui }}</td>
                            <td>@{{ item.NgayHoanThanh }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>