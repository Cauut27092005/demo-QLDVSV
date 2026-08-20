<div class="top-header">
    <div class="thongke-box">
        <div class="mini-card">
            <div class="textthongke">
                <h6>📥 Chờ nhận</h6>
                <h6>[[ thongKe.cho ]]</h6>
            </div>
            <div class="textthongke">
                <h6>⏳ Đang xử lý</h6>
                <h6>[[ thongKe.dang ]]</h6>
            </div>
            <div class="textthongke">
                <h6>✅ Đã xử lý</h6>
                <h6>[[ thongKe.tong ]]</h6>
            </div>
        </div>
    </div>
    <div class="search-bar">
        <input
            class="form-control"
            placeholder="Mã SV, Mã YC, Loại DV"
            v-model="keyword">
        <button
            class="btn btn-primary"
            @click="loadYeuCau">
            🔍 Tìm
        </button>
        <button
            class="btn btn-success"
            @click="xuatExcel">
            📥Excel
        </button>
        <div>
            <input
                type="date"
                class="form-control"
                v-model="tuNgay"
                @change="loadYeuCau()">
        </div>
        <div>
            <input
                type="date"
                class="form-control"
                v-model="denNgay"
                @change="loadYeuCau()">
        </div>
        <button
            class="btn btn-info"
            @click="moLoaiDV">
            <i class="fa-solid fa-list-check me-1"></i>
            Loại dịch vụ
        </button>
    </div>
</div>
<div class="modal fade"
     id="loaiDVModal"
     tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    Loại dịch vụ
                </h5>
                <button
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div
                    v-for="item in loaiDV"
                    :key="item.MaLoai"
                    class="mb-3">
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            :value="item.MaLoai"
                            v-model="chonLoai"
                            :disabled="biKhoa(item)">
                        <label class="form-check-label">
                            [[ item.TenLoai ]]
                        </label>
                    </div>
                    <small
                        v-if="item.MaNV!=null && item.MaNV!=maNV"
                        class="text-danger">
                        Đã có
                        <strong>
                            [[ item.HoTen ]]
                        </strong>
                        phụ trách
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Đóng
                </button>
                <button
                    class="btn btn-primary"
                    @click="luuLoaiDV">
                    Lưu
                </button>
            </div>
        </div>
    </div>
</div>