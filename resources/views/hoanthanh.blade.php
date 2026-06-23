<!DOCTYPE html>
<html>

<head>
    <title>Yêu cầu đã hoàn thành</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand">
                ✅ Danh sách đã hoàn thành
            </span>
            <a href="/nhanvien"
                class="btn btn-light">
                Quay lại
            </a>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                Các yêu cầu đã xử lý
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Mã YC</th>
                        <th>Mã SV</th>
                        <th>Loại dịch vụ</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                    </tr>
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->MaYC }}</td>
                        <td>{{ $item->MaSV }}</td>
                        <td>{{ $item->LoaiDichVu }}</td>
                        <td>{{ $item->NgayGui }}</td>
                        <td>
                            <span class="badge bg-success">
                                Hoàn thành
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</body>

</html>