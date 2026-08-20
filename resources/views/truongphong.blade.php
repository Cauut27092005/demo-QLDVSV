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
                <div v-show="menu=='dashboard'">
                    @include('truongphong.dashboard')
                </div>
                <div v-show="menu=='yeucau'">
                    @include('truongphong.yeucau')
                </div>
                <div v-show="menu=='sla'">
                    @include('truongphong.sla')
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>