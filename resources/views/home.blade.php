<!DOCTYPE html>
<html>

<head>
    <title>Trang sinh viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .main-card {
            max-width: 1200px;
            margin: auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .card-header {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            padding: 15px;
        }

        .service-btn {
            font-size: 14px;
            font-weight: 600;
            min-height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #masv {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            height: 60px;
        }

        .keyboard {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 8px;
            margin-top: 15px;
        }

        .keyboard button {
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            background: #4e73df;
            color: white;
        }

        .keyboard button:hover {
            background: #224abe;
        }

        .special {
            background: #e74a3b !important;
        }

        .space {
            background: #1cc88a !important;
            grid-column: span 4;
        }

        @media(max-width:768px) {

            .keyboard {
                grid-template-columns: repeat(5, 1fr);
            }

            .keyboard button {
                font-size: 16px;
                padding: 10px;
            }
        }
    </style>
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
                        </div>
                    </div>
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
                    <div class="keyboard">
                        <button
                            v-for="key in keys"
                            :key="key"
                            type="button"
                            @click="addKey(key)">
                            [[ key ]]
                        </button>
                        <button
                            type="button"
                            class="space"
                            @click="addKey(' ')">
                            Space
                        </button>
                        <button
                            type="button"
                            class="special"
                            @click="backspace">
                            ⌫
                        </button>
                        <button
                            type="button"
                            class="special"
                            @click="clearInput">
                            Clear
                        </button>
                    </div>
                    <button class="btn btn-success w-100 mt-4">
                        Gửi yêu cầu
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
            delimiters: ['[[', ']]'],
            data() {
                return {
                    masv: '',
                    keys: [
                        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
                        'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
                        'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
                        'Z', 'X', 'C', 'V', 'B', 'N', 'M'
                    ]
                }
            },
            methods: {
                addKey(key) {
                    this.masv += key;
                },
                backspace() {
                    this.masv = this.masv.slice(0, -1);
                },
                clearInput() {
                    this.masv = '';
                }
            }
        }).mount('#app');
    </script>
</body>

</html>