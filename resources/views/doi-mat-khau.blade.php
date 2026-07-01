<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    @vite(['resources/css/login.css'])
    <style>
        body {
            min-height: 100vh;
            background: url('/img/images.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>     
    <div id="app">
        <div class="login-form">
            <h1 class="system-title">
                ĐỔI MẬT KHẨU
            </h1>
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <form method="POST" action="/doi-mat-khau">
                @csrf
                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password"
                        class="form-control input-login"
                        placeholder="Mật khẩu mới"
                        required>
                </div>
                <div class="input-group mb-3">
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control input-login"
                        placeholder="Nhập lại mật khẩu"
                        required>
                </div>
                @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
                @endif
                <button class="btn btn-login-custom">
                    Lưu mật khẩu
                </button>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</body>

</html>