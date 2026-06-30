<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Bảng thông báo</title>

    @vite([
    'resources/js/app.js',
    'resources/js/bang-thongbao.js',
    'resources/css/bang-thongbao.css'
    ])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        rel="stylesheet">
    <style>

    </style>
</head>

<body>
    <div id="app" class="container py-4">
        <div class="header">
            <h2>
                <i class="fa-solid fa-bullhorn"></i>
                HỆ THỐNG THÔNG BÁO DỊCH VỤ SINH VIÊN
            </h2>
            <p>
                Danh sách các yêu cầu đang chờ xử lý và đang được xử lý
            </p>
        </div>
        <div class="card card-custom">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>
                    <i class="fa-solid fa-list-check"></i>
                    Danh sách yêu cầu
                </h4>
                <span class="badge bg-primary">
                    [[ yeucaus.length ]] yêu cầu
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="10%">Mã YC</th>
                            <th width="20%">Mã Sinh viên</th>
                            <th width="45%">Loại dịch vụ</th>
                            <th width="25%">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in yeucaus"
                            :key="item.MaYC">
                            <td>
                                <strong>#[[ item.MaYC ]]</strong>
                            </td>
                            <td>
                                <i class="fa-solid fa-user-graduate text-primary"></i>
                                [[ item.MaSV ]]
                            </td>
                            <td>
                                [[ item.LoaiDichVu ]]
                            </td>
                            <td>
                                <span
                                    v-if="item.TrangThai=='ChoXuLy'"
                                    class="badge bg-warning">
                                    <i class="fa-solid fa-clock"></i>
                                    Chờ xử lý
                                </span>
                                <span
                                    v-else-if="item.TrangThai=='DangXuLy'"
                                    class="badge bg-primary">
                                    <i class="fa-solid fa-spinner"></i>
                                    Đang xử lý
                                </span>
                                <span
                                    v-else-if="item.TrangThai=='HoanThanh'"
                                    class="badge bg-success">

                                    <i class="fa-solid fa-circle-check"></i>
                                    Hoàn thành
                                </span>
                                <span
                                    v-else
                                    class="badge bg-secondary">
                                    [[ item.TrangThai ]]
                                </span>
                            </td>
                        </tr>
                        <tr v-if="yeucaus.length==0">
                            <td colspan="4">
                                <div class="empty-box">
                                    <i class="fa-regular fa-folder-open fa-3x mb-3"></i>
                                    <br>
                                    Chưa có yêu cầu dịch vụ nào
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer">
            © Hệ thống quản lý dịch vụ sinh viên
        </div>
    </div>
</body>

</html>