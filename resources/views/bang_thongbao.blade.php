<!DOCTYPE html>

<html>

<head>
    <title>Bảng thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #0f172a;
            color: white;
            overflow: hidden;
        }

        .title {
            text-align: center;
            font-size: 42px;
            font-weight: bold;
            padding: 20px;
            background: #1e293b;
        }

        .box {
            border-radius: 15px;
            padding: 15px;
            height: 80vh;
        }

        .waiting {
            background: #f59e0b;
        }

        .processing {
            background: #2563eb;
        }

        .done {
            background: #16a34a;
        }

        .item {
            background: rgba(255, 255, 255, 0.15);
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 10px;
            font-size: 20px;
        }

        h3 {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                📢 DANH SÁCH YÊU CẦU DỊCH VỤ SINH VIÊN
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại dịch vụ</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyThongBao">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function loadData() {

            fetch('/api-thongbao')
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    data.forEach(item => {

                        let trangThai = '';

                        if (item.TrangThai == 'ChoXuLy') {
                            trangThai =
                                '<span class="badge bg-warning">Chờ xử lý</span>';
                        } else {
                            trangThai =
                                '<span class="badge bg-primary">Đang xử lý</span>';
                        }

                        html += `
                <tr>
                    <td>${item.MaYC}</td>
                    <td>${item.MaSV}</td>
                    <td>${item.LoaiDichVu}</td>
                    <td>${trangThai}</td>
                </tr>
            `;
                    });

                    document.getElementById(
                        'tbodyThongBao'
                    ).innerHTML = html;

                });

        }

        loadData();

        setInterval(loadData, 2000);
    </script>
</body>

</html>