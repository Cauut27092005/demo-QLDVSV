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
            <div class="title-area">
                <div class="title-icon">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <h3>Bảng thông báo dịch vụ sinh viên</h3>
                    <small>
                        Theo dõi trạng thái xử lý và quầy phục vụ
                    </small>
                </div>
            </div>
            <div class="counter">
                [[ yeucaus.length ]] yêu cầu
            </div>
        </div>
        <div class="card shadow-sm card-custom">
            <div class="card-header">
                <i class="fa-solid fa-list-check me-2"></i>
                Danh sách yêu cầu
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã sinh viên</th>
                            <th>Dịch vụ</th>
                            <th>Quầy</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in yeucaus"
                            :key="item.MaYC">
                            <td>
                                <strong># [[ item.MaYC ]]</strong>
                            </td>
                            <td>
                                <i class="fa-solid fa-user-graduate text-primary me-1"></i>
                                [[ item.MaSV ]]
                            </td>
                            <td>
                                [[ item.LoaiDichVu ]]
                            </td>
                            <td>
                                <span
                                    v-if="item.TrangThai=='DangXuLy'"
                                    class="badge bg-orange">
                                    Quầy [[ item.Quay ]]
                                </span>
                                <span
                                    v-else
                                    class="badge bg-secondary">
                                    Chờ
                                </span>
                            </td>
                            <td>
                                <span
                                    v-if="item.TrangThai=='ChoXuLy'"
                                    class="badge bg-warning text-dark">
                                    Chờ xử lý
                                </span>
                                <span
                                    v-else-if="item.TrangThai=='DangXuLy'"
                                    class="badge bg-primary">
                                    Đang xử lý
                                </span>
                            </td>
                        </tr>
                        <tr v-if="yeucaus.length==0">
                            <td colspan="5">
                                
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