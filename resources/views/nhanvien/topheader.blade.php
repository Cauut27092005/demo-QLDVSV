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
            class="btn btn-warning"
            @click="tuDongNhan">
            ⏱️ Chọn tuần tự
        </button>
    </div>
</div>