<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Models\SinhVien;
use App\Models\TaiKhoan;
use App\Models\YeuCauDichVu;
use App\Models\Admin;
use App\Models\NhanVienXuLy;

Route::get('/', function () {
    return redirect('/login');
});


// ======================
// ĐĂNG NHẬP
// ======================

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
    // Admin
    $admin = Admin::where(
        'Username',
        $request->username
    )->first();
    if (
        $admin &&
        $admin->Password == $request->password
    ) {
        session([
            'login' => true,
            'VaiTro' => 'Admin'
        ]);
        return redirect('/admin');
    }
    // Nhân viên
    $user = TaiKhoan::where(
        'Username',
        $request->username
    )->where(
        'VaiTro',
        'NhanVien'
    )->first();
    if (
        $user &&
        $user->Password == $request->password
    ) {
        session([
            'login' => true,
            'VaiTro' => 'NhanVien',
            'MaNV' => $user->MaNV
        ]);
        return redirect('/nhanvien');
    }
    return back()->with(
        'error',
        'Sai tài khoản hoặc mật khẩu'
    );
});

Route::get('/admin', function () {
    if (session('VaiTro') != 'Admin') {
        return redirect('/login');
    }
    $tongSV = SinhVien::count();
    $tongNV = NhanVienXuLy::count();
    $tongYC = YeuCauDichVu::count();
    $hoanThanh = YeuCauDichVu::where(
        'TrangThai',
        'HoanThanh'
    )->count();
    $sinhviens = SinhVien::all();
    $nhanviens = NhanVienXuLy::all();
    $yeucaus = YeuCauDichVu::all();
    $hoanthanhs = YeuCauDichVu::where(
        'TrangThai',
        'HoanThanh'
    )->get();

    return view(
        'admin',
        compact(
            'tongSV',
            'tongNV',
            'tongYC',
            'hoanThanh',
            'sinhviens',
            'nhanviens',
            'yeucaus',
            'hoanthanhs'
        )
    );
});

// ======================
// Sinh Viên
// ======================


Route::get('/home', function () {

    return view('home');
});


Route::post('/them-sinhvien', function (Request $request) {
    SinhVien::create([
        'MaSV' => $request->masv,
        'HoTen' => $request->hoten,
        'Email' => $request->email,
        'SDT' => $request->sdt
    ]);
    return back();
});

Route::post('/sua-sinhvien/{id}', function (Request $request, $id) {

    $sv = SinhVien::findOrFail($id);

    $sv->update([
        'HoTen' => $request->hoten,
        'Email' => $request->email,
        'SDT' => $request->sdt
    ]);

    return back();
});

Route::get('/xoa-sinhvien/{id}', function ($id) {
    YeuCauDichVu::where(
        'MaSV',
        $id
    )->delete();
    SinhVien::destroy($id);
    return back();
});

Route::get('/quanly-sinhvien', function () {
    if (session('VaiTro') != 'Admin') {
        return redirect('/login');
    }
    $data = SinhVien::all();
    return view(
        'quanly_sinhvien',
        compact('data')
    );
});

// ======================
// Nhân Viên
// ======================

Route::get('/nhanvien', function () {

    if (session('VaiTro') != 'NhanVien') {
        return redirect('/login');
    }
    $maNV = session('MaNV');
    $data = YeuCauDichVu::where(function ($q) use ($maNV) {
        $q->whereNull('MaNV')
            ->orWhere('MaNV', $maNV);
    })
        ->where('TrangThai', '!=', 'HoanThanh')
        ->orderBy('MaYC', 'desc')
        ->get();
    return view(
        'nhanvien',
        compact('data')
    );
});

Route::get('/quanly-nhanvien', function () {
    if (session('VaiTro') != 'Admin') {
        return redirect('/login');
    }
    $data = NhanVienXuLy::all();
    return view(
        'quanly_nhanvien',
        compact('data')
    );
});

Route::post('/them-nhanvien', function (Request $request) {
    $nv = App\Models\NhanVienXuLy::create([
        'HoTen' => $request->hoten,
        'BoPhan' => $request->bophan
    ]);
    TaiKhoan::create([
        'Username' => $request->username,
        'Password' => $request->password,
        'VaiTro' => 'NhanVien',
        'MaNV' => $nv->MaNV
    ]);
    return back();
});

Route::post('/sua-nhanvien/{id}', function (Request $request, $id) {
    $nv = NhanVienXuLy::findOrFail($id);
    $nv->update([
        'HoTen' => $request->hoten,
        'BoPhan' => $request->bophan
    ]);
    return back();
});

Route::get('/xoa-nhanvien/{id}', function ($id) {
    $dangXuLy = YeuCauDichVu::where(
        'MaNV',
        $id
    )
        ->where(
            'TrangThai',
            'DangXuLy'
        )
        ->exists();
    if ($dangXuLy) {
        return back()->with(
            'error',
            'Nhân viên đang xử lý yêu cầu'
        );
    }
    TaiKhoan::where(
        'MaNV',
        $id
    )->delete();
    NhanVienXuLy::destroy($id);
    return back();
});

// ======================
// YÊU CẦU DV
// ======================

Route::post('/yeucau', function (Request $request) {

    $sv = SinhVien::where(
        'MaSV',
        $request->masv
    )->first();

    if (!$sv) {
        return back()->with(
            'error',
            'Mã sinh viên không tồn tại'
        );
    }

    // Tìm nhân viên đang rảnh
    $nv = NhanVienXuLy::whereNotIn(
        'MaNV',
        YeuCauDichVu::where(
            'TrangThai',
            'DangXuLy'
        )->pluck('MaNV')
    )->first();

    YeuCauDichVu::create([
        'MaSV' => $request->masv,
        'LoaiDichVu' => $request->loai,
        'NgayGui' => now(),

        // Nếu có NV rảnh => giao luôn
        'TrangThai' => $nv
            ? 'DangXuLy'
            : 'ChoXuLy',

        'MaNV' => $nv
            ? $nv->MaNV
            : null
    ]);

    return back()->with(
        'success',
        'Gửi yêu cầu thành công'
    );
});

// ======================
// HOÀN THÀNH YÊU CẦU
// ======================

Route::get('/capnhat-hoanthanh/{id}', function ($id) {

    $maNV = session('MaNV');

    $yc = YeuCauDichVu::findOrFail($id);

    if ($yc->MaNV != $maNV) {
        return back();
    }

    // Hoàn thành yêu cầu hiện tại
    $yc->update([
        'TrangThai' => 'HoanThanh'
    ]);

    // Tìm yêu cầu chờ xử lý lâu nhất
    $yeuCauMoi = YeuCauDichVu::where(
        'TrangThai',
        'ChoXuLy'
    )
    ->whereNull('MaNV')
    ->orderBy('MaYC')
    ->first();

    // Tự nhận yêu cầu mới
    if ($yeuCauMoi) {

        $yeuCauMoi->update([
            'MaNV' => $maNV,
            'TrangThai' => 'DangXuLy'
        ]);
    }

    return redirect('/nhanvien');
});

// ======================
// DANH SÁCH HOÀN THÀNH
// ======================

Route::get('/danhsach-hoanthanh', function () {
    $data = YeuCauDichVu::where(
        'TrangThai',
        'HoanThanh'
    )->get();
    return view(
        'hoanthanh',
        compact('data')
    );
});

Route::get('/api-yeucau', function () {
    $maNV = session('MaNV');
    return YeuCauDichVu::where(function ($q) use ($maNV) {

        $q->whereNull('MaNV')
            ->orWhere('MaNV', $maNV);
    })
        ->where('TrangThai', '!=', 'HoanThanh')
        ->orderBy('MaYC', 'desc')
        ->get();
});

// ======================
// ĐĂNG XUẤT
// ======================

Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});
