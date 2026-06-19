<!DOCTYPE html>
<html>

<head>
    <title>Nhân viên xử lý yêu cầu</title>
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

        .new-badge {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="header d-flex justify-content-between">
            <div>
                <h2>👨‍💼 Quản lý yêu cầu sinh viên</h2>
            </div>
            <div>
                <a href="/danhsach-hoanthanh"
                    class="btn btn-light">
                    Đã xử lý
                </a>
                <a href="/logout"
                    class="btn btn-danger">
                    Đăng xuất
                </a>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại dịch vụ</th>
                            <th>Nội dung</th>
                            <th>Ngày gửi</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyYeuCau">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function loadYeuCau() {
            fetch('/api-yeucau')
                .then(response => response.json())
                .then(data => {
                    let html = '';
                    data.forEach(item => {
                        html += `
            <tr>
                <td>${item.MaYC}</td>
                <td>${item.MaSV}</td>
                <td>${item.LoaiDichVu}</td>
                <td>${item.NoiDung}</td>
                <td>${item.NgayGui}</td>
                <td>
                    ${
                        item.TrangThai == 'ChoXuLy'
                        ?
                        '<span class="badge bg-warning">Chờ xử lý</span>'
                        :
                        '<span class="badge bg-primary">Đang xử lý</span>'
                    }
                </td>
                <td>
                    ${
                    item.TrangThai == 'ChoXuLy'
                    ?
                    `
                    <a href="/nhan-yeucau/${item.MaYC}"
                    class="btn btn-primary btn-sm">
                        Nhận
                    </a>
                    `
                    :
                    `
                    <a href="/capnhat-hoanthanh/${item.MaYC}"
                    class="btn btn-success btn-sm">
                        Hoàn thành
                    </a>
                    `
                    }
                </td>
            </tr>
            `;
                    });
                    document.getElementById(
                        'tbodyYeuCau'
                    ).innerHTML = html;
                });
        }
        loadYeuCau();
        setInterval(loadYeuCau, 2000);
    </script>
</body>

</html>