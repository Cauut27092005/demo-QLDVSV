<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Mã YC</th>
                    <th>Mã SV</th>
                    <th>Loại dịch vụ</th>
                    <th>Ngày gửi</th>
                    <th>Nhân viên xử lý</th>
                    <th>Trạng thái</th>
                    <th v-if="tab=='xuly'">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="item in danhSachHienTai"
                    :key="item.MaYC">
                    <td>[[ item.MaYC ]]</td>
                    <td>[[ item.MaSV ]]</td>
                    <td>[[ item.LoaiDichVu ]]</td>
                    <td>[[ item.NgayGui ]]</td>
                    <td>
                        <span v-if="item.TenNhanVien">
                            [[ item.TenNhanVien ]]
                        </span>
                        <span
                            v-else
                            class="text-secondary">
                            Chưa có
                        </span>
                    </td>
                    <td>
                        <span
                            v-if="item.TrangThai=='ChoXuLy'"
                            class="badge bg-warning text-dark">
                            Chờ xử lý
                        </span>
                        <span
                            v-else-if="item.TrangThai=='DangXuLy'"
                            class="badge bg-primary">
                            Đang xử lý
                        </span>
                        <span
                            v-else
                            class="badge bg-success">
                            Hoàn thành
                        </span>
                    </td>
                    <td v-if="tab=='xuly'">
                        <!-- Tab Chờ -->
                        <button
                            v-if="item.TrangThai=='ChoXuLy'"
                            class="btn btn-primary btn-sm"
                            @click="nhanYeuCau(item.MaYC)">
                            Nhận
                        </button>
                        <!-- Tab Đang xử lý -->
                        <button
                            v-else-if="item.TrangThai=='DangXuLy'"
                            class="btn btn-success btn-sm"
                            @click="hoanThanh(item.MaYC)">
                            Hoàn thành
                        </button>
                        <!-- Tab Lịch sử -->
                    </td>
                </tr>
                <tr v-if="danhSachHienTai.length==0">
                    <td :colspan="tab=='xuly' ? 7 : 6" class="text-center">
                        Không có yêu cầu
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal lịch sử -->
<div
    class="modal fade"
    id="lichSuModal"
    tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    Lịch sử yêu cầu đã hoàn thành
                </h5>
                <button
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
                        <tr
                            v-for="item in lichSu"
                            :key="item.MaYC">
                            <td>[[ item.MaYC ]]</td>
                            <td>[[ item.MaSV ]]</td>
                            <td>[[ item.LoaiDichVu ]]</td>
                            <td>[[ item.NgayGui ]]</td>
                            <td>[[ item.NgayHoanThanh ]]</td>
                        </tr>
                        <tr v-if="lichSu.length==0">
                            <td colspan="5" class="text-center">
                                Chưa có yêu cầu nào hoàn thành.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
