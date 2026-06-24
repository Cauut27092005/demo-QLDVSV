<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: #212529;
            color: white;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #343a40;
        }

        .content {
            margin-left: 250px;
            padding: 25px;
        }

        .card {
            border: none;
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="sidebar">
            <h3 class="text-center mt-3">⚙️ Admin</h3>
            <a href="/admin">🏠 Dashboard</a>
            <a href="/quanly-nhanvien">
                👨‍💼 Quản lý nhân viên
            </a>
            <a href="/logout">
                🚪 Đăng xuất
            </a>
        </div>
        <div class="content">
            <div class="d-flex justify-content-between mb-3">
                <h2>Quản lý nhân viên</h2>
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addModal">
                    + Thêm nhân viên
                </button>
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Mã NV</th>
                                <th>Họ tên</th>
                                <th>Bộ phận</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="nv in nhanviens" :key="nv.MaNV">
                                <td>{{ nv.MaNV }}</td>
                                <td>{{ nv.HoTen }}</td>
                                <td>{{ nv.BoPhan }}</td>
                                <td>
                                    <button
                                        class="btn btn-warning btn-sm me-2"
                                        @click="chonNhanVien(nv)"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        Sửa
                                    </button>
                                    <a
                                        :href="'/xoa-nhanvien/' + nv.MaNV"
                                        class="btn btn-danger btn-sm">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal thêm -->
        <div class="modal fade" id="addModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/them-nhanvien" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5>Thêm nhân viên</h5>
                        </div>
                        <div class="modal-body">
                            <input
                                type="text"
                                name="hoten"
                                class="form-control mb-2"
                                placeholder="Họ tên"
                                required>
                            <input
                                type="text"
                                name="bophan"
                                class="form-control mb-2"
                                placeholder="Bộ phận"
                                required>
                            <input
                                type="text"
                                name="username"
                                class="form-control mb-2"
                                placeholder="Username"
                                required>
                            <input
                                type="text"
                                name="password"
                                class="form-control"
                                placeholder="Password"
                                required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">
                                Lưu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal sửa -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form
                        :action="'/sua-nhanvien/' + nhanVienSua.MaNV"
                        method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5>Sửa nhân viên</h5>
                        </div>
                        <div class="modal-body">
                            <input
                                type="text"
                                name="hoten"
                                class="form-control mb-2"
                                v-model="nhanVienSua.HoTen">
                            <input
                                type="text"
                                name="bophan"
                                class="form-control"
                                v-model="nhanVienSua.BoPhan">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const {
            createApp
        } = Vue;
        createApp({
            data() {
                return {
                    nhanviens: [],
                    nhanVienSua: {}
                }
            },
            methods: {
                loadNhanVien() {
                    fetch('/api-nhanvien')
                        .then(res => res.json())
                        .then(data => {
                            this.nhanviens = data;
                        });
                },
                chonNhanVien(nv) {
                    this.nhanVienSua = {
                        ...nv
                    };
                }
            },
            mounted() {
                this.loadNhanVien();
                setInterval(
                    this.loadNhanVien,
                    3000
                );
            }
        }).mount('#app');
    </script>
</body>

</html>