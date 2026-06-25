<!DOCTYPE html>
<html>

<head>
    <title>Bảng thông báo</title>
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
        }

        .title {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }

        .table td,
        .table th {
            vertical-align: middle;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div id="app" class="container-fluid mt-3">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0">
                    📢 DANH SÁCH YÊU CẦU DỊCH VỤ SINH VIÊN
                </h3>
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
                    <tbody>
                        <tr
                            v-for="item in yeucaus"
                            :key="item.MaYC">
                            <td>[[ item.MaYC ]]</td>
                            <td>[[ item.MaSV ]]</td>
                            <td>[[ item.LoaiDichVu ]]</td>
                            <td>
                                <span
                                    v-if="item.TrangThai=='ChoXuLy'"
                                    class="badge bg-warning">
                                    Chờ xử lý
                                </span>
                                <span
                                    v-else
                                    class="badge bg-primary">
                                    Đang xử lý
                                </span>
                            </td>
                        </tr>
                        <tr v-if="yeucaus.length==0">
                            <td colspan="4">
                                Không có dữ liệu
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const {
            createApp
        } = Vue;
        createApp({
            delimiters: ['[[', ']]'],
            data() {
                return {
                    yeucaus: []
                }
            },
            methods: {
                loadData() {
                    fetch('/api-thongbao')
                        .then(res => res.json())
                        .then(data => {
                            this.yeucaus = data;
                        });
                }
            },
            mounted() {
                this.loadYeuCau();
                window.Echo.channel('yeucau')
                    .listen('.DuLieuCapNhat', () => {
                        this.loadYeuCau();
                    });
            }
        }).mount('#app');
    </script>
</body>

</html>