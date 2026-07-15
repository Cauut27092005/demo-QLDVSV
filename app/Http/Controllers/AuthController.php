<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaiKhoan;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function index()
    {
        return view('login');
    }
    // Xử lý đăng nhập
    public function login(Request $request)
{
    $user = TaiKhoan::where(
        'Username',
        $request->username
    )->first();
    if (!$user || $user->Password != $request->password) {
        return back()->with(
            'error',
            'Sai tài khoản hoặc mật khẩu'
        );
    }
    session([
        'login' => true,
        'VaiTro' => $user->VaiTro,
        'Username' => $user->Username
    ]);
    if ($user->VaiTro == 'Admin') {
        return redirect('/admin');
    }
    if ($user->VaiTro == 'TruongPhong') {
        return redirect('/truongphong');
    }
    if ($user->VaiTro == 'NhanVien') {
        return redirect('/nhanvien');
    }
    return back()->with(
        'error',
        'Vai trò không hợp lệ'
    );
}
    
    // Đăng xuất
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}