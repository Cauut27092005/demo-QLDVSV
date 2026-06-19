<!DOCTYPE html>
<html>

<head>
    <title>Quản lý nhân viên</title>
    <style>
        .content {
            margin-left: 250px;
            padding: 25px;
            transition: 0.3s;
        }

        .content.expanded {
            margin-left: 80px;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
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
            font-size: 24px;
            font-weight: bold;
            padding: 20px 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            transition: 0.3s;
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
            color: white;
            text-align: center;
            cursor: pointer;
            font-size: 22px;
            padding: 10px;
            border-bottom: 1px solid #444;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div id="sidebar" class="sidebar">
        <div class="logo">
            ⚙️
        </div>
        <div
            class="toggle-btn"
            onclick="toggleSidebar()">
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
        <a href="/quanly-sinhvien">
            🎓
            <span class="menu-text">
                Quản lý sinh viên
            </span>
        </a>
        <a href="/logout">
            🚪
            <span class="menu-text">
                Đăng xuất
            </span>
        </a>
    </div>
    <div id="content" class="content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Quản lý nhân viên</h2>
            <!-- NÚT THÊM -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                + Thêm nhân viên
            </button>
        </div>
        <!-- BẢNG -->
        <table class="table table-bordered">
            <tr>
                <th>Mã NV</th>
                <th>Họ tên</th>
                <th>Bộ phận</th>
                <th width="180">Thao tác</th>
            </tr>
            <tbody>
                @foreach($data as $nv)
                <tr>
                    <td>{{ $nv->MaNV }}</td>
                    <td>{{ $nv->HoTen }}</td>
                    <td>{{ $nv->BoPhan }}</td>
                    <td>
                        <button
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#edit{{ $nv->MaNV }}">
                            Sửa
                        </button>
                        <a
                            href="/xoa-nhanvien/{{ $nv->MaNV }}"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Xóa nhân viên này?')">
                            Xóa
                        </a>

                    </td>
                </tr>
                <!-- Modal sửa -->
                <div class="modal fade" id="edit{{ $nv->MaNV }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form
                                action="/sua-nhanvien/{{ $nv->MaNV }}"
                                method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5>Sửa nhân viên</h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Họ tên</label>
                                        <input
                                            type="text"
                                            name="hoten"
                                            class="form-control"
                                            value="{{ $nv->HoTen }}"
                                            required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Bộ phận</label>
                                        <input
                                            type="text"
                                            name="bophan"
                                            class="form-control"
                                            value="{{ $nv->BoPhan }}"
                                            required>
                                    </div>
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
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- MODAL THÊM NHÂN VIÊN -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/them-nhanvien" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm nhân viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Họ tên</label>
                            <input type="text" name="hoten" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Bộ phận</label>
                            <input type="text" name="bophan" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document
                .getElementById('sidebar')
                .classList.toggle('collapsed');
            document
                .getElementById('content')
                .classList.toggle('expanded');
        }
    </script>
</body>

</html>