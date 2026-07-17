<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trưởng phòng</title>
    @vite([
    'resources/css/truongphong.css',
    'resources/js/truongphong.js'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="wrapper">
            @include('truongphong.sidebar')
            <main class="content">
                @include('truongphong.topheader')
                <div v-show="menu=='dashboard'">
                    @include('truongphong.dashboard')
                    <div
                        class="modal fade"
                        id="chiTietModal"
                        tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5>Chi tiết yêu cầu</h5>
                                    <button
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Mã YC</th>
                                                <th>Mã SV</th>
                                                <th>Loại DV</th>
                                                <th>Ngày gửi</th>
                                                <th>Ngày hoàn thành</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="item in chiTiet"
                                                :key="item.MaYC">
                                                <td>[[ item.MaYC ]]</td>
                                                <td>[[ item.MaSV ]]</td>
                                                <td>[[ item.LoaiDichVu ]]</td>
                                                <td>[[ item.NgayGui ]]</td>
                                                <td>[[ item.NgayHoanThanh ]]</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="menu=='yeucau'">
                    @include('truongphong.yeucau')
                </div>
                <div v-show="menu=='thongke'">
                    @include('truongphong.thongke')
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>