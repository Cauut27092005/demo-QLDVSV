<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập hệ thống</title>
    <!-- Thêm font chữ Inter hiện đại giống thiết kế mẫu -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                HỆ THỐNG
            </h1>
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <form method="POST" action="/login">
                @csrf
                <div class="input-group mb-3">
                    <input
                        type="text"
                        name="username"
                        class="form-control input-login"
                        placeholder="Tài khoản"
                        v-model="username"
                        required>
                    <span class="input-group-text icon-login">
                        👤
                    </span>
                </div>
                <div class="input-group mb-3">
                    <input
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        class="form-control input-login"
                        placeholder="Mật khẩu"
                        v-model="password"
                        required>
                    <span class="input-group-text icon-login">
                        🔒
                    </span>
                </div>
                <button class="btn btn-login-custom">
                    ĐĂNG NHẬP
                </button>
                <div class="mt-3 text-white d-flex justify-content-between">
                    <label>
                        <input
                            class="form-check-input form-check-input-custom"
                            type="checkbox"
                            id="showPass"
                            v-model="showPassword">
                        Hiện mật khẩu
                    </label>
                </div>
            </form>
        </div>
    </div>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const {
            createApp
        } = Vue;
        createApp({
            data() {
                return {
                    username: '',
                    password: '',
                    showPassword: false
                }
            }
        }).mount('#app');
    </script>
</body>

</html>