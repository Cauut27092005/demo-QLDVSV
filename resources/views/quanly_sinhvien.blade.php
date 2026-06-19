<!DOCTYPE html>
<html>

<head>
    <title>Quản lý sinh viên</title>
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
        <div class="d-flex justify-content-between mb-3">
            <h2>Quản lý sinh viên</h2>

            <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#addModal">
                + Thêm sinh viên
            </button>
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Mã SV</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $sv)
                <tr>
                    <td>{{ $sv->MaSV }}</td>
                    <td>{{ $sv->HoTen }}</td>
                    <td>{{ $sv->Email }}</td>
                    <td>{{ $sv->SDT }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">
                        Chưa có sinh viên
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="/them-sinhvien" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Thêm sinh viên
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-2">
                            <label>Mã SV</label>
                            <input
                                type="text"
                                name="masv"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-2">
                            <label>Họ tên</label>
                            <input
                                type="text"
                                name="hoten"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control">
                        </div>

                        <div class="mb-2">
                            <label>SĐT</label>
                            <input
                                type="text"
                                name="sdt"
                                class="form-control">
                        </div>

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