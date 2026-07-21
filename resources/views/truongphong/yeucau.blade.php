<div class="yeucau">
    <div class="card shadow">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <input
                        class="form-control"
                        placeholder="Tìm mã YC, mã SV..."
                        v-model="keyword"
                        @keyup.enter="loadYeuCau">
                </div>
                <div class="col-md-2">
                    <input
                        type="date"
                        class="form-control"
                        v-model="tuNgay">
                </div>
                <div class="col-md-2">
                    <input
                        type="date"
                        class="form-control"
                        v-model="denNgay">
                </div>
                <div class="col-md-2">
                    <select
                        class="form-select"
                        v-model="trangThai">
                        <option value="">
                            Tất cả
                        </option>
                        <option value="ChoXuLy">
                            Chờ xử lý
                        </option>
                        <option value="DangXuLy">
                            Đang xử lý
                        </option>
                        <option value="HoanThanh">
                            Hoàn thành
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
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
                                v-if="item.TrangThai=='ChoXuLy'">
                                Chờ xử lý
                            </span>
                            <span
                                class="badge bg-primary"
                                v-else-if="item.TrangThai=='DangXuLy'">
                                Đang xử lý
                            </span>
                            <span
                                class="badge bg-success"
                                v-else>
                                Hoàn thành
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>