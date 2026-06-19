<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết yêu cầu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Chi tiết yêu cầu
            </div>
            <div class="card-body">
                <p><strong>Mã yêu cầu:</strong> {{ $item->MaYC }}</p>
                <p><strong>Mã sinh viên:</strong> {{ $item->MaSV }}</p>
                <p><strong>Loại dịch vụ:</strong> {{ $item->LoaiDichVu }}</p>
                <p><strong>Nội dung:</strong></p>
                <div class="alert alert-light">
                    {{ $item->NoiDung }}
                </div>
                <p><strong>Ngày gửi:</strong> {{ $item->NgayGui }}</p>
                <p>
                    <strong>Trạng thái:</strong>

                    @if($item->TrangThai == 'ChoXuLy')
                    <span class="badge bg-warning">Chờ xử lý</span>
                    @elseif($item->TrangThai == 'DangXuLy')
                    <span class="badge bg-primary">Đang xử lý</span>
                    @else
                    <span class="badge bg-success">Hoàn thành</span>
                    @endif
                </p>
                <a href="/danhsach-hoanthanh"
                    class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</body>

</html>