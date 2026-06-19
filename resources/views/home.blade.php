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
                        <label>Loại dịch vụ</label>
                        <select
                            name="loai"
                            class="form-control"
                            required>
                            <option value="">
                                -- Chọn --
                            </option>
                            <option>
                                Xác nhận sinh viên
                            </option>
                            <option>
                                Cấp giấy tờ
                            </option>
                            <option>
                                Hỗ trợ học vụ
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nội dung yêu cầu</label>
                        <textarea
                            name="noidung"
                            class="form-control"
                            rows="4"
                            required></textarea>
                    </div>
                    <button class="btn btn-success">
                        Gửi yêu cầu
                    </button>
                </form>
            </div>
        </div>
</body>

</html>