<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nhân viên xử lý yêu cầu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite([
    'resources/css/nhanvien.css',
    'resources/js/nhanvien.js'
    ])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
    <div id="app" data-username="{{ session('MaNV') }}">
        <div class="wrapper">
            @include('nhanvien.sidebar')
            <main class="content">
                @include('nhanvien.topheader')
                @include('nhanvien.danhsach')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>