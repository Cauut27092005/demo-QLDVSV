<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;
use App\Models\NhanVienXuLy;
use Illuminate\Support\Facades\Http;
use App\Events\DuLieuCapNhat;

class YeuCauController extends Controller
{
    public function store(Request $request)
    {

        $ip = $request->ip();
        // if (!str_starts_with($ip, '10.82.'))
        if ( $ip !== '127.0.0.1' &&
            $ip !== '::1' &&
            !str_starts_with($ip, '10.82.') ) 
        {
            return back()->with(
                'error',
                'Hệ thống chỉ được sử dụng trong khu vực của trường.'
            );
        }
        // Kiểm tra sinh viên có tồn tại không
        $response = Http::get(
            'http://localhost:3000/sinhvien',
            ['MaSV' => $request->masv]
        );
        $sinhVien = $response->json();
        if (count($sinhVien) == 0) {
            return back()->with(
                'error',
                'Mã sinh viên không tồn tại trong hệ thống'
            );
        }
        // Tạo yêu cầu mới
        YeuCauDichVu::create([
            'MaSV'        => $request->masv,
            'LoaiDichVu'  => $request->loai,
            'NgayGui'     => now(),
            'TrangThai'   => 'ChoXuLy',
            'MaNV'        => null
        ]);
        event(new DuLieuCapNhat());
        return back()->with(
            'success',
            'Gửi yêu cầu thành công'
        );
    }
}
