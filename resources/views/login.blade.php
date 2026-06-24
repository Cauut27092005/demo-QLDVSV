<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 450px;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .2);
        }

        .login-header {
            background: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .login-header h2 {
            margin: 0;
            font-weight: bold;
        }

        .card-body {
            padding: 30px;
        }

        .form-control {
            height: 50px;
            border-radius: 10px;
        }

        .btn-login {
            height: 50px;
            font-weight: bold;
            border-radius: 10px;
        }

        .logo {
            font-size: 55px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="card login-card">
            <div class="login-header">
                <div class="logo">
                    🎓
                </div>
                <h2>
                    Đăng nhập hệ thống
                </h2>
            </div>
            <div class="card-body">
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Tài khoản
                        </label>
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Nhập tài khoản"
                            v-model="username"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Mật khẩu
                        </label>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            name="password"
                            class="form-control"
                            placeholder="Nhập mật khẩu"
                            v-model="password"
                            required>
                    </div>
                    <div class="form-check mb-3">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="showPass"
                            v-model="showPassword">
                        <label
                            class="form-check-label"
                            for="showPass">
                            Hiện mật khẩu
                        </label>
                    </div>
                    <button
                        class="btn btn-success btn-login w-100">
                        Đăng nhập
                    </button>
                </form>
            </div>
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