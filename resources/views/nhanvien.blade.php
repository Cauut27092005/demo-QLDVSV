<!DOCTYPE html>
<html>

<head>
    <title>Nhân viên xử lý yêu cầu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
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

        .table th {
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div id="app" class="container mt-4">
        <div class="header d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                👨‍💼 Quản lý yêu cầu sinh viên
            </h2>
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
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Mã YC</th>
                            <th>Mã SV</th>
                            <th>Loại dịch vụ</th>
                            <th>Ngày gửi</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in yeucaus"
                            :key="item.MaYC">
                            <td>[[ item.MaYC ]]</td>
                            <td>[[ item.MaSV ]]</td>
                            <td>[[ item.LoaiDichVu ]]</td>
                            <td>[[ item.NgayGui ]]</td>
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
                            <td>
                                <a
                                    v-if="item.TrangThai=='DangXuLy'"
                                    :href="'/capnhat-hoanthanh/' + item.MaYC"
                                    class="btn btn-success btn-sm">
                                    Hoàn thành
                                </a>
                            </td>
                        </tr>
                        <tr v-if="yeucaus.length==0">
                            <td colspan="6"
                                class="text-center">
                                Không có yêu cầu
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
                loadYeuCau() {
                    fetch('/api-yeucau')
                        .then(res => res.json())
                        .then(data => {
                            this.yeucaus = data;
                        });
                }
            },
            mounted() {
                this.loadYeuCau();
                setInterval(() => {
                    this.loadYeuCau();
                }, 2000);
            }
        }).mount('#app');
    </script>
</body>

</html>