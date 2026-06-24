<!DOCTYPE html>
<html>

<head>
    <title>Yêu cầu đã hoàn thành</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div id="app">

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

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>
                                <th>Mã YC</th>
                                <th>Mã SV</th>
                                <th>Loại dịch vụ</th>
                                <th>Ngày gửi</th>
                                <th>Trạng thái</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr
                                v-for="item in data"
                                :key="item.MaYC">

                                <td>[[ item.MaYC ]]</td>

                                <td>[[ item.MaSV ]]</td>

                                <td>[[ item.LoaiDichVu ]]</td>

                                <td>[[ item.NgayGui ]]</td>

                                <td>

                                    <span class="badge bg-success">

                                        Hoàn thành

                                    </span>

                                </td>

                            </tr>

                            <tr v-if="data.length==0">

                                <td colspan="5"
                                    class="text-center">

                                    Chưa có dữ liệu

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

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
                    data: []
                }
            },
            methods: {
                loadData() {
                    fetch('/api-hoanthanh')
                        .then(res => res.json())
                        .then(result => {
                            this.data = result;
                        });
                }
            },
            mounted() {
                this.loadData();
                setInterval(() => {
                    this.loadData();
                }, 5000);
            }
        }).mount('#app');
    </script>
</body>

</html>