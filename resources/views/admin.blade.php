<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <style>
        body {
            background: #f4f6f9;
        }

        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
            cursor: pointer;
            transition: .3s;
            height: 150px;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card .card-body {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .number {
            font-size: 42px;
            font-weight: bold;
        }

        .table-box {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div id="app" class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Dashboard Admin</h2>
                <small>Xin chào Admin 👋</small>
            </div>
            <a href="/logout" class="btn btn-danger">
                Đăng xuất
            </a>
        </div>
        <!-- CARD -->
        <div class="row g-3">
            <div class="col-md-3">
                <div
                    class="card dashboard-card bg-dark text-white"
                    @click="show='tk'">
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
                    @click="show='nv'">
                    <div class="card-body text-center">
                        <h5>Nhân viên</h5>
                        <div class="number">
                            @{{ tongNV }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card dashboard-card bg-warning"
                    @click="show='yc'">
                    <div class="card-body text-center">
                        <h5>Tổng yêu cầu</h5>
                        <div class="number">
                            @{{ tongYC }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card dashboard-card bg-info text-white"
                    @click="show='dxl'">
                    <div class="card-body text-center">
                        <h5>Đang xử lý</h5>
                        <div class="number">
                            @{{ dangXuLy }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card dashboard-card bg-success text-white"
                    @click="show='ht'">
                    <div class="card-body text-center">
                        <h5>Đã xử lý</h5>
                        <div class="number">
                            @{{ hoanThanh }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- NHÂN VIÊN -->
        <div
            v-if="show=='nv'"
            class="card shadow table-box">
            <div class="card-header bg-primary text-white">
                Danh sách nhân viên
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã NV</th>
                            <th>Họ tên</th>
                            <th>Bộ phận</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in nhanViens"
                            :key="item.MaNV">
                            <td>@{{ item.MaNV }}</td>
                            <td>@{{ item.HoTen }}</td>
                            <td>@{{ item.BoPhan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- YÊU CẦU -->
        <div
            v-if="show=='yc'"
            class="card shadow table-box">
            <div class="card-header bg-warning">
                Danh sách yêu cầu
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại DV</th>
                            <th>Ngày gửi</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in yeuCaus"
                            :key="item.MaYC">
                            <td>@{{ item.MaYC }}</td>
                            <td>@{{ item.MaSV }}</td>
                            <td>@{{ item.LoaiDichVu }}</td>
                            <td>@{{ item.NgayGui }}</td>
                            <td>@{{ item.TrangThai }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- ĐANG XỬ LÝ -->
        <div
            v-if="show=='dxl'"
            class="card shadow table-box">
            <div class="card-header bg-info text-white">
                Danh sách đang xử lý
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại DV</th>
                            <th>Ngày gửi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in dangXuLys"
                            :key="item.MaYC">
                            <td>@{{ item.MaYC }}</td>
                            <td>@{{ item.MaSV }}</td>
                            <td>@{{ item.LoaiDichVu }}</td>
                            <td>@{{ item.NgayGui }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- HOÀN THÀNH -->
        <div
            v-if="show=='ht'"
            class="card shadow table-box">
            <div class="card-header bg-success text-white">
                Danh sách đã hoàn thành
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại DV</th>
                            <th>Ngày gửi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in hoanThanhs"
                            :key="item.MaYC">
                            <td>@{{ item.MaYC }}</td>
                            <td>@{{ item.MaSV }}</td>
                            <td>@{{ item.LoaiDichVu }}</td>
                            <td>@{{ item.NgayGui }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div
            v-if="show=='tk'"
            class="card shadow table-box">
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in thongKeNhanVien"
                            :key="item.MaNV">
                            <td>@{{ item.MaNV }}</td>
                            <td>@{{ item.HoTen }}</td>
                            <td>
                                <span class="badge bg-success">
                                    @{{ item.SoLuong }}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        Vue.createApp({
            data() {
                return {
                    tongNV: 0,
                    tongYC: 0,
                    dangXuLy: 0,
                    hoanThanh: 0,
                    nhanViens: [],
                    yeuCaus: [],
                    dangXuLys: [],
                    hoanThanhs: [],
                    thongKeNhanVien: [],
                    tuNgay: '',
                    denNgay: '',
                    show: ''
                }
            },
            mounted() {
                this.loadData();
                setInterval(() => {
                    this.loadData();
                }, 2000);
            },
            methods: {
                loadData() {
                    fetch('/api-admin')
                        .then(res => res.json())
                        .then(data => {
                            this.tongNV = data.tongNV;
                            this.tongYC = data.tongYC;
                            this.dangXuLy = data.dangXuLy;
                            this.hoanThanh = data.hoanThanh;
                            this.nhanViens = data.nhanViens;
                            this.yeuCaus = data.yeuCaus;
                            this.dangXuLys = data.dangXuLys;
                            this.hoanThanhs = data.hoanThanhs;
                        });
                },
                loadThongKe() {
                    if (!this.tuNgay || !this.denNgay) {
                        alert('Chọn khoảng thời gian');
                        return;
                    }
                    fetch(
                            `/api-thongke-nhanvien?tuNgay=${this.tuNgay}&denNgay=${this.denNgay}`
                        )
                        .then(res => res.json())
                        .then(data => {
                            this.thongKeNhanVien = data;
                        });
                }
            }
        }).mount('#app');
    </script>
</body>

</html>