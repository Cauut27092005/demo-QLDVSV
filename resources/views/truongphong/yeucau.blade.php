<div class="yeucau">
    <div class="card shadow">
        <div class="card-header">
            <div class="row g-2">
                <!-- Tìm kiếm -->
                <div class="col-md-3">
                    <input
                        class="form-control"
                        placeholder="Tìm mã YC, mã SV..."
                        v-model="keyword"
                        @keyup.enter="loadYeuCau()">
                </div>
                <!-- Từ ngày -->
                <div class="col-md-2">
                    <input
                        type="date"
                        class="form-control"
                        v-model="tuNgay">
                </div>
                <!-- Đến ngày -->
                <div class="col-md-2">
                    <input
                        type="date"
                        class="form-control"
                        v-model="denNgay">
                </div>
                <!-- Loại dịch vụ -->
                <div class="col-md-2">
                    <select
                        class="form-select"
                        v-model="maLoai">
                        <option value="">
                            Tất cả loại dịch vụ
                        </option>
                        <option
                            v-for="item in loaiDichVu"
                            :key="item.MaLoai"
                            :value="item.MaLoai">
                            [[ item.TenLoai ]]
                        </option>
                    </select>
                </div>
                <!-- Trạng thái -->
                <div class="col-md-2">
                    <select
                        class="form-select"
                        v-model="trangThai">
                        <option value="">
                            Tất cả trạng thái
                        </option>
                        <option value="DaXuLy">
                            Đã xử lý
                        </option>
                        <option value="Huy">
                            Hủy
                        </option>
                    </select>
                </div>
                <!-- Nút lọc -->
                <div class="col-md-1">
                    <button
                        class="btn btn-primary w-100"
                        @click="loadYeuCau()">
                        Lọc
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Mã YC</th>
                        <th>Mã SV</th>
                        <th>Loại DV</th>
                        <th>Ngày gửi</th>
                        <th>Nhân viên</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in yeuCaus"
                        :key="item.MaYC">
                        <td>[[ item.MaYC ]]</td>
                        <td>[[ item.MaSV ]]</td>
                        <td>[[ item.LoaiDichVu ]]</td>
                        <td>[[ item.NgayGui ]]</td>
                        <td>
                            [[ item.TenNhanVien ?? 'Chưa có' ]]
                        </td>
                        <td>
                            <span
                                class="badge bg-warning"
                                v-if="item.TrangThai == 'ChoXuLy'">
                                Chờ xử lý
                            </span>
                            <span
                                class="badge bg-primary"
                                v-else-if="item.TrangThai == 'DangXuLy'">
                                Đang xử lý
                            </span>
                            <span
                                class="badge bg-success"
                                v-else-if="item.TrangThai == 'HoanThanh'">
                                Hoàn thành
                            </span>
                            <span
                                class="badge bg-danger"
                                v-else-if="item.TrangThai == 'Huy'">
                                Đã hủy
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>