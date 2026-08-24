<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\TruongPhongController;
use App\Http\Controllers\YeuCauController;
use App\Http\Controllers\ThongBaoController;
use App\Http\Controllers\GoogleController;

Route::get('/', function () {
    return redirect('/login');
});


// ======================
// ĐĂNG NHẬP, ĐĂNG XUẤT
// ======================

Route::get('/auth/google', [AuthController::class, 'googleRedirect']);

Route::get('/auth/google/callback', [AuthController::class, 'googleCallback']);

Route::get('/login', [AuthController::class, 'index']);

Route::get('/logout', [AuthController::class, 'logout']);

// ======================
// Sinh Viên
// ======================

Route::get('/home', function () {
    return view('home');
});

// ======================
//  ADMIN
// ======================

Route::get('/admin', [AdminController::class, 'index']);

Route::post('/api-nhanvien/add', [AdminController::class, 'addNV']);

Route::post('/api-nhanvien/update', [AdminController::class, 'updateNV']);

Route::delete('/api-nhanvien/delete/{id}', [AdminController::class, 'deleteNV']);

Route::post('/api-nhanvien/reset-password/{maNV}', [AdminController::class, 'resetPassword']);

Route::get('/api-nhanvien', [AdminController::class, 'nhanVien']);

Route::get('/quanly-nhanvien', [AdminController::class, 'QL_NV']);

//=========================
// GOOGLE ACCOUNT
//=========================

Route::get('/quanly-google', [AdminController::class, 'QL_Google']);

Route::get('/api-google', [AdminController::class, 'apiGoogle']);

Route::get('/api-google', [AdminController::class, 'taiKhoanGoogle']);

Route::post('/api-google/duyet', [AdminController::class, 'duyetGoogle']);

Route::post('/api-google/tuchoi', [AdminController::class, 'tuChoiGoogle']);

// ======================
//  Nhân Viên
// ======================

Route::get('/nhanvien', [NhanVienController::class, 'index']);

Route::get('/api-yeucau', [NhanVienController::class, 'api_YC']);

Route::get('/api-thongke-nhanvien', [NhanVienController::class, 'thongKe']);

Route::get('/api-loai-dv', [NhanVienController::class, 'layLoaiDV']);

Route::post('/api-loai-dv', [NhanVienController::class, 'luuLoaiDV']);

Route::get('/xuat-excel', [NhanVienController::class, 'xuatExcel']);

Route::post('/nhanvien/tu-dong-nhan', [NhanVienController::class, 'tuDongNhan']);

Route::get('/nhan-yeu-cau/{id}', [NhanVienController::class, 'nhanYeuCau']);

Route::get('/capnhat-hoanthanh/{id}', [NhanVienController::class, 'CN_HT']);

Route::post('/nhanvien/huy/{id}', [NhanVienController::class, 'huyYeuCau']);

Route::get('/api-canhbao-sla', [NhanVienController::class, 'canhBaoSLA']);

// ======================
//  Trưởng phòng
// ======================

Route::get('/truongphong', [TruongPhongController::class, 'index']);

Route::get('/api-tp-dashboard', [TruongPhongController::class, 'dashboard']);

Route::get('/api-tp-yeucau', [TruongPhongController::class, 'yeuCau']);

Route::get('/api-tp-chart-loaidv', [TruongPhongController::class, 'chartLoaiDichVu']);

Route::get('/api-tp-sla', [TruongPhongController::class, 'dsSLA']);

Route::post('/api-tp-sla', [TruongPhongController::class, 'capNhatSLA']);

Route::get('/truongphong/baocao', [TruongPhongController::class, 'xuatBaoCao']);

Route::get('/api-tp-thongke', [TruongPhongController::class, 'thongKe']);

Route::get("/api-tp-top", [TruongPhongController::class, "topNhanVien"]);

Route::get('/api-tp-chitiet/{maNV}', [TruongPhongController::class, 'chiTiet']);

Route::get('/truongphong/excel/topnhanvien', [TruongPhongController::class, 'excelTopNhanVien']);

Route::get('/truongphong/excel/yeucau', [TruongPhongController::class, 'excelYeuCau']);

// ======================
// YÊU CẦU, HOÀN THÀNH
// ======================

Route::post('/yeucau', [YeuCauController::class, 'store']);

Route::get('/bang-thongbao', [ThongBaoController::class, 'index']);

Route::get('/api-thongbao', [ThongBaoController::class, 'api_TB']);

Route::get('/test-socket', function () {
    event(new \App\Events\DuLieuCapNhat('hello'));
    return 'OK';
});

Route::get('/test-session', function () {
    session(['test_session' => 'hello']);

    return response()->json([
        'session_id' => session()->getId(),
        'test_session' => session('test_session'),
        'cookie' => config('session.cookie'),
        'domain' => config('session.domain'),
        'secure' => config('session.secure'),
        'same_site' => config('session.same_site'),
    ]);
});
Route::get('/test-cookie', function () {

    $response = response('COOKIE TEST')
        ->header(
            'Set-Cookie',
            'test_cookie=hello; Max-Age=7200; Path=/; Secure; HttpOnly; SameSite=Lax'
        );

    logger()->info('TEST COOKIE RESPONSE', [
        'headers' => $response->headers->all(),
        'set_cookie' => $response->headers->get('Set-Cookie'),
    ]);

    return $response;
});

Route::get('/test-cookie-debug', function () {
    return response()->json([
        'headers' => request()->headers->all(),
        'server' => [
            'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'] ?? null,
            'HTTP_X_FORWARDED_PROTO' => $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null,
            'HTTP_X_FORWARDED_HOST' => $_SERVER['HTTP_X_FORWARDED_HOST'] ?? null,
        ],
    ])->header('X-Test-Header', 'hello')
        ->header(
            'Set-Cookie',
            'debug_cookie=hello; Max-Age=7200; Path=/; Secure; HttpOnly; SameSite=Lax'
        );
});
