<!DOCTYPE html>
<html>

<head>
    <title>Trang sinh viên</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .btn {
            font-size: 12px;
            font-weight: 600;
            min-height: 45px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .card-body {
            padding: 15px;
        }

        .header {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .keyboard {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .keyboard button {
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            background: #4e73df;
            color: white;
            transition: 0.2s;
        }

        .keyboard button:hover {
            background: #224abe;
        }

        .keyboard .special {
            background: #e74a3b;
        }

        .keyboard .special:hover {
            background: #c0392b;
        }

        .keyboard .space {
            grid-column: span 4;
            background: #1cc88a;
        }

        .keyboard .space:hover {
            background: #17a673;
        }

        #masv {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            height: 55px;
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

    <div class="container mt-4">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                Gửi yêu cầu dịch vụ
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
                    <div class="mb-2">

                        <label class="form-label fw-bold">
                            Chọn loại dịch vụ
                        </label>

                        <div class="row g-1">

                            <div class="col">
                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv1"
                                    value="Xác nhận sinh viên"
                                    required>

                                <label class="btn btn-outline-primary w-100 h-100"
                                    for="dv1">
                                    Xác nhận SV
                                </label>
                            </div>

                            <div class="col">
                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv2"
                                    value="Cấp giấy tờ">

                                <label class="btn btn-outline-success w-100 h-100"
                                    for="dv2">
                                    Cấp giấy tờ
                                </label>
                            </div>

                            <div class="col">
                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv3"
                                    value="Hỗ trợ học vụ">

                                <label class="btn btn-outline-warning w-100 h-100"
                                    for="dv3">
                                    Hỗ trợ học vụ
                                </label>
                            </div>

                            <div class="col">
                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv4"
                                    value="Bảo lưu">

                                <label class="btn btn-outline-info w-100 h-100"
                                    for="dv4">
                                    Bảo lưu
                                </label>
                            </div>

                            <div class="col">
                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv5"
                                    value="Cấp lại thẻ">

                                <label class="btn btn-outline-danger w-100 h-100"
                                    for="dv5">
                                    Cấp lại thẻ
                                </label>
                            </div>

                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Mã sinh viên
                        </label>

                        <input
                            type="text"
                            id="masv"
                            name="masv"
                            class="form-control"
                            readonly
                            required>

                        <div class="keyboard mt-3" id="keyboard">
                        </div>
                    </div>



                    <button class="btn btn-success w-100">
                        Gửi yêu cầu
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>
        const keys = [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P',
            'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L',
            'Z', 'X', 'C', 'V', 'B', 'N', 'M'
        ];

        const keyboard = document.getElementById('keyboard');
        const input = document.getElementById('masv');

        keys.forEach(key => {

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.innerText = key;

            btn.onclick = () => {
                input.value += key;
            };

            keyboard.appendChild(btn);
        });

        const spaceBtn = document.createElement('button');
        spaceBtn.type = 'button';
        spaceBtn.innerText = 'Space';
        spaceBtn.classList.add('space');

        spaceBtn.onclick = () => {
            input.value += ' ';
        };

        keyboard.appendChild(spaceBtn);

        const backBtn = document.createElement('button');
        backBtn.type = 'button';
        backBtn.innerText = '⌫';
        backBtn.classList.add('special');

        backBtn.onclick = () => {
            input.value = input.value.slice(0, -1);
        };

        keyboard.appendChild(backBtn);

        const clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.innerText = 'Clear';
        clearBtn.classList.add('special');

        clearBtn.onclick = () => {
            input.value = '';
        };

        keyboard.appendChild(clearBtn);
    </script>

</body>

</html>