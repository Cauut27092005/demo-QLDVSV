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
            <div class="top-title">
                <h2>Hệ thống xếp hàng tự động - Automatic queuing system</h2>
                <p>
                    Vui lòng đăng ký thông tin để được phục vụ /
                    Please fill in the required information.
                </p>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div id="alert-message" class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div id="alert-message" class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <form action="/yeucau" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="service-title">
                            Vui lòng chọn loại thủ tục cần phục vụ /
                            Please select the service
                        </label>
                        <div class="row g-2">
                            <div class="service-list">
                                <label>
                                    <input type="radio" name="loai" value="1" required>
                                    Thủ tục hành chính (thẻ, giấy xác nhận)
                                </label>
                                <label>
                                    <input type="radio" name="loai" value="2">
                                    Thủ tục học vụ
                                </label>
                                <label>
                                    <input type="radio" name="loai" value="3">
                                    Tài chính
                                </label>
                                <label>
                                    <input type="radio" name="loai" value="4">
                                    Khác
                                </label>
                                <label>
                                    <input type="radio" name="loai" value="5">
                                    QHDN
                                </label>
                                <label>
                                    <input type="radio" name="loai" value="6">
                                    Nhà trọ, phòng trọ
                                </label>
                                <label>
                                    <input type="radio" name="loai" value="7">
                                    Hỗ trợ CNTT
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 text-center">
                        <label class="form-title text-center w-100">
                            MSSV hoặc họ tên /
                            Roll number or full name
                        </label>
                        <input
                            type="text"
                            id="masv"
                            name="masv"
                            class="student-input "
                            v-model="masv"
                            readonly
                            required>
                    </div>
                    <button type="submit" class="submit-btn">
                        Gửi yêu cầu
                    </button>
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
                </form>
            </div>
        </div>
    </div>
</body>

</html>