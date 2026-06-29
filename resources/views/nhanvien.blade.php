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
    <div id="app" class="container mt-4">
        <div class="header d-flex justify-content-between align-items-center">
            <h2>👨‍💼 Quản lý yêu cầu sinh viên</h2>
            <div>
                <button
                    class="btn btn-light"
                    @click="moLichSu">
                    Đã xử lý
                </button>
                <a href="/logout"
                    class="btn btn-danger">
                    Đăng xuất
                </a>
            </div>
        </div>
        @include('nhanvien.danhsach')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>