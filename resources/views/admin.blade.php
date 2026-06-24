<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: #f4f6f9;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: #212529;
            transition: 0.3s;
            overflow: hidden;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .logo {
            text-align: center;
            color: white;
            font-size: 32px;
            padding: 15px 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
        }

        .sidebar a:hover {
            background: #343a40;
        }

        .menu-text {
            margin-left: 10px;
        }

        .sidebar.collapsed .menu-text {
            display: none;
        }

        .toggle-btn {
            text-align: center;
            color: white;
            font-size: 22px;
            cursor: pointer;
            padding: 10px;
            border-bottom: 1px solid #444;
        }

        /* CONTENT */

        .content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 20px;
            transition: 0.3s;
        }

        .content.expanded {
            margin-left: 80px;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            border-radius: 15px;
            padding: 15px 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            margin-bottom: 25px;
        }

        /* CARD */
        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
            cursor: pointer;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .number {
            font-size: 36px;
            font-weight: bold;
        }

        /* TABLE */
        .table {
            margin-bottom: 0;
        }

        .card {
            border: none;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="sidebar">
            <div class="logo">⚙️</div>
            <div
                class="toggle-btn"
                @click="toggleSidebar">
                ☰
            </div>
            <a href="/admin">
                🏠
                <span class="menu-text">
                    Dashboard
                </span>
            </a>
            <a href="/quanly-nhanvien">
                👨‍💼
                <span class="menu-text">
                    Quản lý nhân viên
                </span>
            </a>
            <a href="/logout">
                🚪
                <span class="menu-text">
                    Đăng xuất
                </span>
            </a>
        </div>
        <div
            class="content"
            :class="{expanded:collapsed}">
            <h3>Dashboard Quản Trị</h3>
            <div>Xin chào Admin 👋</div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div
                        class="card dashboard-card bg-success text-white"
                        @click="showTable('nv')">
                        <div class="card-body">
                            <h5>Nhân viên</h5>
                            <div class="number">
                                [[ tongNV ]]
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div
                        class="card dashboard-card bg-warning"
                        @click="showTable('yc')">
                        <div class="card-body">
                            <h5>Yêu cầu</h5>
                            <div class="number">
                                [[ tongYC ]]
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div
                        class="card dashboard-card bg-info text-white"
                        @click="showTable('ht')">
                        <div class="card-body">
                            <h5>Đã xử lý</h5>
                            <div class="number">
                                [[ hoanThanh ]]
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-4">
                <div class="card-header bg-dark text-white">
                    Chi tiết dữ liệu
                </div>
                <div class="card-body">
                    <!-- NHAN VIEN -->
                    <div v-show="table=='nv'">
                        <h4>Danh sách nhân viên</h4>
                        <table class="table table-bordered">
                            <thead class="table-success">
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
                                    <td>[[ nv.MaNV ]]</td>
                                    <td>[[ nv.HoTen ]]</td>
                                    <td>[[ nv.BoPhan ]]</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- YEU CAU -->
                    <div v-show="table=='yc'">
                        <h4>Danh sách yêu cầu</h4>
                        <table class="table table-bordered">
                            <thead class="table-warning">
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
                                    v-for="yc in yeucaus"
                                    :key="yc.MaYC">
                                    <td>[[ yc.MaYC ]]</td>
                                    <td>[[ yc.MaSV ]]</td>
                                    <td>[[ yc.LoaiDichVu ]]</td>
                                    <td>[[ yc.NgayGui ]]</td>
                                    <td>[[ yc.TrangThai ]]</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- HOAN THANH -->
                    <div v-show="table=='ht'">
                        <h4>Danh sách đã hoàn thành</h4>
                        <table class="table table-bordered">
                            <thead class="table-info">
                                <tr>
                                    <th>Mã YC</th>
                                    <th>Mã SV</th>
                                    <th>Loại DV</th>
                                    <th>Ngày gửi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="ht in hoanthanhs"
                                    :key="ht.MaYC">
                                    <td>[[ ht.MaYC ]]</td>
                                    <td>[[ ht.MaSV ]]</td>
                                    <td>[[ ht.LoaiDichVu ]]</td>
                                    <td>[[ ht.NgayGui ]]</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const {
            createApp
        } = Vue;
        createApp({
            delimiters: ['[[', ']]'],
            data() {
                return {
                    collapsed: false,
                    table: '',
                    tongNV: 0,
                    tongYC: 0,
                    hoanThanh: 0,
                    nhanviens: [],
                    yeucaus: [],
                    hoanthanhs: []
                }
            },
            methods: {
                toggleSidebar() {
                    this.collapsed = !this.collapsed;
                },
                showTable(type) {
                    this.table = type;
                },
                loadData() {
                    fetch('/api-admin')
                        .then(res => res.json())
                        .then(data => {
                            this.tongNV = data.tongNV;
                            this.tongYC = data.tongYC;
                            this.hoanThanh = data.hoanThanh;
                            this.nhanviens = data.nhanviens;
                            this.yeucaus = data.yeucaus;
                            this.hoanthanhs = data.hoanthanhs;
                        });
                }
            },
            mounted() {
                this.loadData();
                setInterval(() => {
                    this.loadData();
                }, 3000);
            }
        }).mount('#app');
    </script>
</body>

</html>