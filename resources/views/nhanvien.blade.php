<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nhân viên xử lý yêu cầu</title>
    @vite([
    'resources/css/nhanvien.css',
    'resources/js/nhanvien.js'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="wrapper">
            <!-- Sidebar -->
            <aside class="sidebar">
                <div class="logo">
                </div>
                <ul class="menu">
                    <li class="active">
                        📄 Quản lý yêu cầu
                    </li>
                    <li @click="moLichSu">
                        📋 Đã xử lý
                    </li>
                    <li @click="moDoiMK">
                        🔑 Đổi mật khẩu
                    </li>
                    <li>
                        <a href="/logout">
                            🚪 Đăng xuất
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- Content -->
            <main class="content">
                <div class="header">
                    <h2>Quản lý yêu cầu sinh viên</h2>
                </div>
                @include('nhanvien.danhsach')
                @include('nhanvien.doimatkhau')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>