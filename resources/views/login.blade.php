<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập hệ thống</title>
    <!-- Thêm font chữ Inter hiện đại giống thiết kế mẫu -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .35);
            backdrop-filter: blur(5px);
        }

        .login-form {
            width: 360px;
            position: relative;
            z-index: 2;
        }

        .system-title {
            text-align: center;
            color: white;
            font-size: 48px;
            font-weight: 300;
            margin-bottom: 40px;
        }

        .input-login {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .8);
            border-right: none;
            color: white;
            height: 50px;
            border-radius: 0;
        }

        .input-login::placeholder {
            color: white;
        }

        .input-login:focus {
            background: rgba(255, 255, 255, .15);
            color: white;
            box-shadow: none;
            border-color: white;
        }

        .icon-login {
            background: rgba(255, 255, 255, .08);
            color: white;
            border: 1px solid rgba(255, 255, 255, .8);
            border-left: none;
            border-radius: 0;
        }

        .btn-login-custom {
            width: 100%;
            height: 50px;
            background: white;
            border: none;
            border-radius: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .btn-login-custom:hover {
            background: #ececec;
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