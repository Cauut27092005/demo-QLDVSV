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
    <div id="app" class="container mt-4">
        <div class="card shadow main-card">
            <div class="card-header bg-primary text-white">
                🎓 GỬI YÊU CẦU DỊCH VỤ
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
                    <div class="mb-3">
                        <label class="fw-bold mb-2">
                            Chọn loại dịch vụ
                        </label>

                        <div class="row g-2">
                            <div class="col">
                                <input
                                    class="btn-check"
                                    type="radio"
                                    name="loai"
                                    id="dv1"
                                    value="Xác nhận sinh viên"
                                    required>
                                <label
                                    class="btn btn-outline-primary w-100 service-btn"
                                    for="dv1">
                                    📄 Xác nhận SV
                                </label>
                            </div>

                            <div class="col">
                                <input
                                    class="btn-check"
                                    type="radio"
                                    name="loai"
                                    id="dv2"
                                    value="Cấp giấy tờ">
                                <label
                                    class="btn btn-outline-success w-100 service-btn"
                                    for="dv2">
                                    📝 Cấp giấy tờ
                                </label>
                            </div>

                            <div class="col">
                                <input
                                    class="btn-check"
                                    type="radio"
                                    name="loai"
                                    id="dv3"
                                    value="Hỗ trợ học vụ">
                                <label
                                    class="btn btn-outline-warning w-100 service-btn"
                                    for="dv3">
                                    🎓 Hỗ trợ học vụ
                                </label>
                            </div>

                            <div class="col">
                                <input
                                    class="btn-check"
                                    type="radio"
                                    name="loai"
                                    id="dv4"
                                    value="Bảo lưu">
                                <label
                                    class="btn btn-outline-info w-100 service-btn"
                                    for="dv4">
                                    📚 Bảo lưu
                                </label>
                            </div>

                            <div class="col">
                                <input
                                    class="btn-check"
                                    type="radio"
                                    name="loai"
                                    id="dv5"
                                    value="Cấp lại thẻ">
                                <label
                                    class="btn btn-outline-danger w-100 service-btn"
                                    for="dv5">
                                    🪪 Cấp lại thẻ
                                </label>
                            </div>

                            <div class="col">
                                <input
                                    class="btn-check"
                                    type="radio"
                                    name="loai"
                                    id="dv6"
                                    value="Khác">
                                <label
                                    class="btn btn-outline-secondary w-100 service-btn"
                                    for="dv6">
                                    💬 Khác
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Giữ nguyên toàn bộ phần radio của bạn -->

                    <div class="mb-3">
                        <label class="fw-bold">
                            Mã sinh viên
                        </label>

                        <input
                            type="text"
                            id="masv"
                            name="masv"
                            class="form-control"
                            v-model="masv"
                            readonly
                            required>
                    </div>

                    <div class="keyboard-box">

                        <div class="keyboard-row">
                            <button class="key"
                                v-for="k in numbers"
                                @click="addKey(k)"
                                type="button">
                                [[ k ]]
                            </button>
                        </div>

                        <div class="keyboard-row">
                            <button class="key"
                                v-for="k in row1"
                                @click="addKey(k)"
                                type="button">
                                [[ k ]]
                            </button>
                        </div>

                        <div class="keyboard-row">
                            <button class="key"
                                v-for="k in row2"
                                @click="addKey(k)"
                                type="button">
                                [[ k ]]
                            </button>
                        </div>

                        <div class="keyboard-row">

                            <button class="key"
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

                    <button class="btn btn-success w-100 mt-4">
                        Gửi yêu cầu
                    </button>

                </form>

            </div>
        </div>
    </div>
</body>

</html>