<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DuLieuCapNhat;
use Laravel\Socialite\Facades\Socialite;
use App\Models\TkGoogle;
use App\Models\Users;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function index()
    {
        return view('login');
    }
    // Xử lý đăng nhập
    public function googleRedirect()
    {
        $url = Socialite::driver('google')->redirect()->getTargetUrl();
        logger()->info('GOOGLE REDIRECT', [
            'session_id' => session()->getId(),
            'session_state' => session()->get('state'),
            'url' => $url,
        ]);
        return redirect($url);
    }
    public function googleCallback()
    {
        logger()->info('GOOGLE CALLBACK', [
            'session_id' => session()->getId(),
            'session_state' => session()->get('state'),
            'google_state' => request('state'),
        ]);
        $googleUser = Socialite::driver('google')->user();
        $taiKhoan = TkGoogle::where('Email', $googleUser->email)->first();
        // Chưa có trong hệ thống
        if (!$taiKhoan) {
            TkGoogle::create([
                'GoogleID'  => $googleUser->id,
                'Email'     => $googleUser->email,
                'TrangThai' => 'ChoDuyet',
            ]);
            event(new DuLieuCapNhat(
                'GoogleMoi',
                [
                    'Email' => $googleUser->email
                ]
            ));
            return redirect('/login')->with(
                'error',
                'Tài khoản của bạn đã được gửi tới Admin để xét duyệt.'
            );
        }
        // Chờ duyệt
        if ($taiKhoan->TrangThai == 'ChoDuyet') {
            return redirect('/login')->with(
                'error',
                'Tài khoản đang chờ Admin phê duyệt.'
            );
        }
        // Bị từ chối
        if ($taiKhoan->TrangThai == 'TuChoi') {
            return redirect('/login')->with(
                'error',
                'Tài khoản của bạn đã bị từ chối.'
            );
        }
        // Hoạt động
        if ($taiKhoan->TrangThai == 'HoatDong') {
            $data = [
                'LanDangNhapCuoi' => now(),
            ];
            if (!$taiKhoan->GoogleID) {
                $data['GoogleID'] = $googleUser->id;
            }
            if (!$taiKhoan->MaNV) {
                return redirect('/login')->with(
                    'error',
                    'Tài khoản chưa được liên kết với nhân viên.'
                );
            }
            $user = Users::find($taiKhoan->MaNV);
            if (!$user) {
                return redirect('/login')->with(
                    'error',
                    'Không tìm thấy thông tin nhân viên.'
                );
            }
            $taiKhoan->update($data);
            session([
                'login'  => true,
                'MaNV'   => $taiKhoan->MaNV,
                'VaiTro' => $taiKhoan->VaiTro,
                'Email'  => $taiKhoan->Email,
            ]);
            switch ($taiKhoan->VaiTro) {
                case 'Admin':
                    return redirect('/admin');
                case 'TruongPhong':
                    return redirect('/truongphong');
                case 'NhanVien':
                    return redirect('/nhanvien');
                default:
                    return redirect('/login')->with(
                        'error',
                        'Vai trò không hợp lệ.'
                    );
            }
        }
        return redirect('/login');
    }
    // Đăng xuất
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
