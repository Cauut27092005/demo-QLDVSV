<!DOCTYPE html>
<html>

<head>
    <title>Đăng nhập nhân viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-login {
            width: 420px;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }
    </style>
</head>

<body>
    <div class="card card-login p-4">
        <h2 class="text-center mb-4">
            Đăng nhập nhân viên
        </h2>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label class="form-label">
                    Mã nhân viên
                </label>
                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Nhập mã nhân viên"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">
                    Mật khẩu
                </label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Nhập mật khẩu"
                    required>
            </div>
            <button class="btn btn-success w-100">
                Đăng nhập
            </button>
        </form>
    </div>
</body>

</html>