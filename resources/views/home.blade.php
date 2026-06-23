    <!DOCTYPE html>
    <html>

    <head>
        <title>Trang sinh viên</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: #f4f6f9;
            }

            .header {
                background: linear-gradient(135deg, #4e73df, #1cc88a);
                color: white;
                padding: 20px;
                border-radius: 15px;
                margin-bottom: 20px;
            }
        </style>
    </head>

    <body>
        <div class="container mt-4">
            <div class="header d-flex justify-content-between">
                <h2>🎓 Hệ thống dịch vụ sinh viên</h2>
            </div>
            <!-- FORM GỬI YÊU CẦU -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    Gửi yêu cầu dịch vụ
                </div>
                <div class="card-body">
                    <form action="/yeucau" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Mã sinh viên</label>
                            <input
                                type="text"
                                name="masv"
                                class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Loại dịch vụ
                            </label>

                            <div class="d-grid gap-2">

                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv1"
                                    value="Xác nhận sinh viên"
                                    required>

                                <label class="btn btn-outline-primary text-start"
                                    for="dv1">
                                    📄 Xác nhận sinh viên
                                </label>

                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv2"
                                    value="Cấp giấy tờ">

                                <label class="btn btn-outline-success text-start"
                                    for="dv2">
                                    📝 Cấp giấy tờ
                                </label>

                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv3"
                                    value="Hỗ trợ học vụ">

                                <label class="btn btn-outline-warning text-start"
                                    for="dv3">
                                    🎓 Hỗ trợ học vụ
                                </label>

                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv4"
                                    value="Bảo lưu">

                                <label class="btn btn-outline-info text-start"
                                    for="dv4">
                                    📚 Bảo lưu kết quả học tập
                                </label>

                                <input type="radio" class="btn-check"
                                    name="loai"
                                    id="dv5"
                                    value="Cấp lại thẻ">

                                <label class="btn btn-outline-danger text-start"
                                    for="dv5">
                                    🪪 Cấp lại thẻ sinh viên
                                </label>

                            </div>
                        </div>
                        <button class="btn btn-success">
                            Gửi yêu cầu
                        </button>
                    </form>
                </div>
            </div>
    </body>

    </html>