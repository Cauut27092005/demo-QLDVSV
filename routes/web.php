<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\YeuCauController;
use App\Http\Controllers\ThongBaoController;


Route::get('/', function () {
    return redirect('/login');
});


// ======================
// ĐĂNG NHẬP, ĐĂNG XUẤT
// ======================

Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
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

Route::get('/api-admin', [AdminController::class, 'api_admin']);

Route::get('/api-dashboard', [AdminController::class, 'dashboard']);

Route::get('/api-thongke-nhanvien', [AdminController::class, 'api_THK_NV']);

Route::get('/api-chitiet-nhanvien/{maNV}', [AdminController::class, 'api_CHT_NV']);

Route::post('/api-nhanvien/add', [AdminController::class, 'addNV']);

Route::post('/api-nhanvien/update', [AdminController::class, 'updateNV']);

Route::delete('/api-nhanvien/delete/{id}', [AdminController::class, 'deleteNV']);

Route::get('/api-nhanvien', [AdminController::class, 'nhanVien']);

Route::get('/quanly-nhanvien', [AdminController::class, 'QL_NV']);

Route::get('/api-yeucau-admin', [AdminController::class, 'yeuCau']);

Route::get('/api-dangxuly', [AdminController::class, 'dangXuLy']);

Route::get('/api-hoanthanh', [AdminController::class, 'hoanThanh']);

// ======================
//  Nhân Viên
// ======================

Route::get('/nhanvien', [NhanVienController::class, 'index']);

Route::get('/api-yeucau', [NhanVienController::class, 'api_YC']);

Route::get('/capnhat-hoanthanh/{id}', [NhanVienController::class, 'CN_HT']);

Route::get('/api-lichsu', [NhanVienController::class, 'da_xu_ly']);

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
