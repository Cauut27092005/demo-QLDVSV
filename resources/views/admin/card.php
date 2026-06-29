    <div class="row g-3">
        <div class="col-md-3">
            <div
                class="card dashboard-card bg-dark text-white"
                @click="openPage('tk')">
                <div class="card-body text-center">
                    <h5>Thống kê NV</h5>
                    <div class="number">
                        📊
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div
                class="card dashboard-card bg-primary text-white"
                @click="openPage('nv')">
                <div class="card-body text-center">
                    <h5>Nhân viên</h5>
                    <div class="number">
                        {{ tongNV }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div
                class="card dashboard-card bg-warning"
                @click="openPage('yc')">
                <div class="card-body text-center">
                    <h5>Tổng yêu cầu</h5>
                    <div class="number">
                        {{ tongYC }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div
                class="card dashboard-card bg-info text-white"
                @click="openPage('dxl')">
                <div class="card-body text-center">
                    <h5>Đang xử lý</h5>
                    <div class="number">
                        {{ dangXuLy }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div
                class="card dashboard-card bg-success text-white"
                @click="openPage('ht')">
                <div class="card-body text-center">
                    <h5>Đã xử lý</h5>
                    <div class="number">
                        {{ hoanThanh }}
                    </div>
                </div>
            </div>
        </div>
    </div>
