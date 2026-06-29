<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    @vite([
    'resources/css/admin.css',
    'resources/js/admin.js'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

</head>

<body>
    <div id="app" class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>Dashboard Admin</h2>
                <small>Xin chào Admin 👋</small>
            </div>
            <a href="/logout" class="btn btn-danger">
                Đăng xuất
            </a>
        </div>
        <div id="app" class="container mt-4">

            {{-- Card --}}
            @include('admin.card')

            {{-- Nội dung --}}
            <div class="mt-4">

                <div v-show="show=='tk'">
                    @include('admin.thongke')
                </div>

                <div v-show="show=='nv'">
                    @include('admin.nhanvien')
                </div>

                <div v-show="show=='yc'">
                    @include('admin.yeucau')
                </div>

                <div v-show="show=='dxl'">
                    @include('admin.dangxuly')
                </div>

                <div v-show="show=='ht'">
                    @include('admin.hoanthanh')
                </div>

            </div>

        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>