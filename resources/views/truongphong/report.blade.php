<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo thống kê</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }
        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }
        .center {
            text-align: center;
        }
        .title {
            margin-bottom: 25px;
        }
        .title h2 {
            color: #0d6efd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 25px;
        }
        table th {
            background: #0d6efd;
            color: white;
            border: 1px solid #666;
            padding: 8px;
        }
        table td {
            border: 1px solid #666;
            padding: 8px;
        }
        .tongquan {
            width: 70%;
            margin: auto;
        }
        .tongquan td {
            padding: 10px;
        }
        .section {
            margin-top: 20px;
        }
        .footer {
            margin-top: 70px;
        }
        .left {
            width: 50%;
            float: left;
            text-align: center;
        }
        .right {
            width: 50%;
            float: right;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="title center">
        <h2>HỆ THỐNG QUẢN LÝ DỊCH VỤ SINH VIÊN</h2>
        <h3>BÁO CÁO THỐNG KÊ</h3>
        <p>Ngày xuất: {{ date('d/m/Y H:i') }}</p>
    </div>
    <div class="section">
        <h3>I. Tổng quan</h3>
        <table class="tongquan">
            <tr>
                <td>Tổng số yêu cầu</td>
                <td>{{ $tong }}</td>
            </tr>
            <tr>
                <td>Chờ xử lý</td>
                <td>{{ $cho }}</td>
            </tr>
            <tr>
                <td>Đang xử lý</td>
                <td>{{ $dang }}</td>
            </tr>
            <tr>
                <td>Hoàn thành</td>
                <td>{{ $hoanThanh }}</td>
            </tr>
            <tr>
                <td>Tỷ lệ hoàn thành</td>
                <td>{{ $tyLe }} %</td>
            </tr>
        </table>
    </div>
    <div class="section">
        <h3>II. Thống kê theo loại dịch vụ</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Loại dịch vụ</th>
                    <th>Tổng yêu cầu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loaiDichVu as $index=>$item)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $item->TenLoai }}</td>
                    <td>{{ $item->Tong }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="section">
        <h3>III. Hiệu suất nhân viên</h3>
        <table>
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Hoàn thành</th>
                    <th>Đạt SLA</th>
                    <th>Quá SLA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nhanVien as $nv)
                <tr>
                    <td>{{ $nv->MaNV }}</td>
                    <td>{{ $nv->HoTen }}</td>
                    <td>{{ $nv->HoanThanh }}</td>
                    <td>{{ $nv->DatSLA }}</td>
                    <td>{{ $nv->QuaSLA }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="section">
        <h3>IV. Danh sách yêu cầu quá SLA</h3>
        <table>
            <thead>
                <tr>
                    <th>Mã YC</th>
                    <th>Mã SV</th>
                    <th>Nhân viên</th>
                    <th>Loại dịch vụ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quaHan as $item)
                <tr>
                    <td>{{ $item->MaYC }}</td>
                    <td>{{ $item->MaSV }}</td>
                    <td>{{ $item->HoTen }}</td>
                    <td>{{ $item->TenLoai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" align="center">
                        Không có yêu cầu quá SLA
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="section">
        <h3>V. Kết luận</h3>
        <p>
            Trong kỳ thống kê hệ thống tiếp nhận
            <b>{{ $tong }}</b>
            yêu cầu.
            Đã hoàn thành
            <b>{{ $hoanThanh }}</b>
            yêu cầu,
            đạt
            <b>{{ $tyLe }}%</b>.
        </p>
    </div>
    <div class="footer">
        <div class="left">
            Người lập báo cáo
            <br><br><br><br>
            (Ký và ghi rõ họ tên)
        </div>
        <div class="right">
            Trưởng phòng
            <br><br><br><br>
            (Ký và ghi rõ họ tên)
        </div>
    </div>
</body>

</html>