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
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .number {
            font-size: 40px;
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
        <div class="row">

            <div class="col-md-3 mb-3">
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
            <div class="col-md-4 mb-3">
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
            <div class="col-md-4 mb-3">
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
            <div class="col-md-4 mb-3">
                <div
                    class="card dashboard-card bg-success text-white"
                    @click="show='ht'">
                    <div class="card-body text-center">
                        <h5>Hoàn thành</h5>
                        <div class="number">
                            @{{ hoanThanh }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            v-for="nv in nhanviens"
                            :key="nv.MaNV">
                            <td>@{{ nv.MaNV }}</td>
                            <td>@{{ nv.HoTen }}</td>
                            <td>@{{ nv.BoPhan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Danh sách yêu cầu -->
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
                            <th>Loại dịch vụ</th>
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
        <!-- Đang xử lý -->
        <div
            v-if="show=='dxl'"
            class="card shadow table-box">
            <div class="card-header bg-info text-white">
                Đang xử lý
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
        <!-- Hoàn thành -->
        <div
            v-if="show=='ht'"
            class="card shadow table-box">
            <div class="card-header bg-success text-white">
                Đã hoàn thành
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
    </div>
    <script>
        Vue.createApp({
            data() {
                return {
                    tongNV: 0,
                    tongYC: 0,
                    dangXuLy: 0,
                    hoanThanh: 0,
                    nhanviens: [],
                    yeuCaus: [],
                    dangXuLys: [],
                    hoanThanhs: [],
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
                            this.nhanviens = data.nhanviens;
                            this.yeuCaus = data.yeuCaus;
                            this.dangXuLys = data.dangXuLys;
                            this.hoanThanhs = data.hoanThanhs;
                        });
                }
            }
        }).mount('#app');
    </script>
</body>

</html>