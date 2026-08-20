<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập hệ thống</title>
    <meta name="theme-color" content="#0d6efd">
    <link rel="manifest" href="/build/manifest.webmanifest">
    <link rel="icon" href="/icon-192.png">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/login.css'
    ])
</head>

<body>
    <div class="overlay"></div>
    <div class="login-form">
        <h1 class="system-title">
            HỆ THỐNG
        </h1>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <a href="{{ url('/auth/google') }}"
            class="btn btn-danger w-100 py-3">
            Đăng nhập bằng Google
        </a>
        <div class="mt-4 text-center text-white">
            Nếu tài khoản chưa được cấp quyền,
            hãy đăng nhập bằng Google để gửi yêu cầu
            tới quản trị viên.
        </div>
    </div>
</body>
</html>