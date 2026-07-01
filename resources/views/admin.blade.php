<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin</title>
    @vite([
    'resources/css/admin.css',
    'resources/js/admin.js'
    ])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>DỊCH VỤ SV</span>
            </div>
            <div
                class="menu-item"
                :class="{active:show=='tk'}"
                @click="openPage('tk')">
                <i class="fa-solid fa-chart-column"></i>
                <span>Thống kê</span>
            </div>
            <div
                class="menu-item"
                :class="{active:show=='nv'}"
                @click="openPage('nv')">
                <i class="fa-solid fa-users"></i>
                <span>Nhân viên</span>
            </div>
            <div
                class="menu-item"
                :class="{active:show=='yc'}"
                @click="openPage('yc')">
                <i class="fa-solid fa-file-lines"></i>
                <span>Yêu cầu</span>
            </div>
            <div
                class="menu-item"
                :class="{active:show=='dxl'}"
                @click="openPage('dxl')">
                <i class="fa-solid fa-spinner"></i>
                <span>Đang xử lý</span>
            </div>

            <div
                class="menu-item"
                :class="{active:show=='ht'}"
                @click="openPage('ht')">
                <i class="fa-solid fa-circle-check"></i>
                <span>Hoàn thành</span>
            </div>
        </div>
        <!-- Main -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div>
                    <h2>Dashboard Admin</h2>
                    <small>
                        Hệ thống quản lý dịch vụ sinh viên
                    </small>
                </div>
                <div>
                    <a
                        href="/logout"
                        class="btn btn-danger">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Đăng xuất
                    </a>
                </div>
            </div>
            <!-- Statistic -->
            <div class="row mt-4">
                <div class="col-lg-3">
                    <div class="stat-card blue">
                        <div>
                            <h2>@{{ tongNV }}</h2>
                            <span>Nhân viên</span>
                        </div>
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="stat-card orange">
                        <div>
                            <h2>@{{ tongYC }}</h2>
                            <span>Yêu cầu</span>
                        </div>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="stat-card yellow">
                        <div>
                            <h2>@{{ dangXuLy }}</h2>
                            <span>Đang xử lý</span>
                        </div>
                        <i class="fa-solid fa-spinner"></i>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="stat-card green">
                        <div>
                            <h2>@{{ hoanThanh }}</h2>
                            <span>Hoàn thành</span>
                        </div>
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
            </div>
            <!-- Content -->
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