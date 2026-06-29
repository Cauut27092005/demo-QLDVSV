<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\TaiKhoan;
use App\Models\NhanVienXuLy;
use App\Models\YeuCauDichVu;
use App\Events\DuLieuCapNhat;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function index(){
        return view('login');
    }

    // Xử lý đăng nhập
    
    public function login(Request $request){
        // Admin
        $admin = Admin::where('Username', $request->username)->first();
        if ($admin && $admin->Password == $request->password) {
            session([
                'login' => true,
                'VaiTro' => 'Admin'
            ]);
            return redirect('/admin');
        }
        // Nhân viên
        $user = TaiKhoan::where('Username', $request->username)
            ->where('VaiTro', 'NhanVien')
            ->first();
        if ($user && $user->Password == $request->password) {
            // Online
            NhanVienXuLy::where('MaNV', $user->MaNV)
                ->update([
                    'TrangThaiOnline' => 1
                ]);
            // Lấy yêu cầu chờ
            $yeuCauCho = YeuCauDichVu::where('TrangThai', 'ChoXuLy')
                ->whereNull('MaNV')
                ->orderBy('MaYC')
                ->first();
            if ($yeuCauCho) {
                $dangXuLy = YeuCauDichVu::where('MaNV', $user->MaNV)
                    ->where('TrangThai', 'DangXuLy')
                    ->exists();
                if (!$dangXuLy) {
                    $yeuCauCho->update([
                        'MaNV' => $user->MaNV,
                        'TrangThai' => 'DangXuLy'
                    ]);
                    event(new DuLieuCapNhat());
                }
            }
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
    }

    // Đăng xuất

    public function logout(){
        if (session('VaiTro') == 'NhanVien') {
            NhanVienXuLy::where(
                'MaNV',
                session('MaNV')
            )->update([
                'TrangThaiOnline' => 0
            ]);
        }
        session()->flush();
        return redirect('/login');
    }
}