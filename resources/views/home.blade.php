<!DOCTYPE html>
<html>

<head>
    <title>Trang sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite([
    'resources/css/home.css',
    'resources/js/home.js'
    ])
</head>
<body>
    <div id="app" class="container py-4">
        <div class="card shadow-lg main-card">
            <div class="card-header text-center text-white">
                <h2 class="mb-0">
                    🎓 GỬI YÊU CẦU DỊCH VỤ
                </h2>
                <small>
                    Vui lòng chọn loại dịch vụ và nhập mã sinh viên
                </small>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form action="/yeucau" method="POST">
                    @csrf
                    <div class="mb-4">
                        <h5 class="mb-3 fw-bold">
                            Chọn loại dịch vụ
                        </h5>
                        <div class="service-grid">
                            <input
                                class="btn-check"
                                type="radio"
                                name="loai"
                                id="dv1"
                                value="Xác nhận sinh viên"
                                required>
                            <label class="service-btn" for="dv1">
                                📄
                                <span>Xác nhận sinh viên</span>
                            </label>
                            <input
                                class="btn-check"
                                type="radio"
                                name="loai"
                                id="dv2"
                                value="Cấp giấy tờ">
                            <label class="service-btn" for="dv2">
                                📑
                                <span>Cấp giấy tờ</span>
                            </label>
                            <input
                                class="btn-check"
                                type="radio"
                                name="loai"
                                id="dv3"
                                value="Hỗ trợ học vụ">
                            <label class="service-btn" for="dv3">
                                🎓
                                <span>Hỗ trợ học vụ</span>
                            </label>
                            <input
                                class="btn-check"
                                type="radio"
                                name="loai"
                                id="dv4"
                                value="Bảo lưu">
                            <label class="service-btn" for="dv4">
                                🛑
                                <span>Bảo lưu</span>
                            </label>
                            <input
                                class="btn-check"
                                type="radio"
                                name="loai"
                                id="dv5"
                                value="Cấp lại thẻ">
                            <label class="service-btn" for="dv5">
                                💳
                                <span>Cấp lại thẻ</span>
                            </label>
                            <input
                                class="btn-check"
                                type="radio"
                                name="loai"
                                id="dv6"
                                value="Khác">
                            <label class="service-btn" for="dv6">
                                ⚙️
                                <span>Khác</span>
                            </label>
                        </div>
                    </div>
            </div>
            <!-- Mã sinh viên -->
            <div class="mb-4">
                <label class="form-title">
                    Mã sinh viên
                </label>
                <input
                    type="text"
                    id="masv"
                    name="masv"
                    class="student-input"
                    v-model="masv"
                    readonly
                    required>
            </div>
            <!-- Keyboard -->
            <div class="keyboard-box">
                <div class="keyboard-row">
                    <button
                        class="key"
                        v-for="k in numbers"
                        @click="addKey(k)"
                        type="button">
                        [[ k ]]
                    </button>
                </div>
                <div class="keyboard-row">
                    <button
                        class="key"
                        v-for="k in row1"
                        @click="addKey(k)"
                        type="button">
                        [[ k ]]
                    </button>
                </div>
                <div class="keyboard-row">
                    <button
                        class="key"
                        v-for="k in row2"
                        @click="addKey(k)"
                        type="button">
                        [[ k ]]
                    </button>
                </div>
                <div class="keyboard-row">
                    <button
                        class="key"
                        v-for="k in row3"
                        @click="addKey(k)"
                        type="button">
                        [[ k ]]
                    </button>
                    <button
                        class="backspace"
                        @click="backspace"
                        type="button">
                        ⌫
                    </button>
                </div>
            </div>
            <button
                type="submit"
                class="submit-btn">
                📤 GỬI YÊU CẦU
            </button>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
</body>

</html>