<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;
use App\Models\NhanVienXuLy;
use Illuminate\Support\Facades\Http;
use App\Events\DuLieuCapNhat;

class YeuCauController extends Controller
{
    public function store(Request $request){
        // Gọi API JSON Server
    $response = Http::get(
        'http://localhost:3000/sinhvien',
        [
            'MaSV' => $request->masv
        ]
    );
    $sinhVien = $response->json();
    if (count($sinhVien) == 0) {
        return back()->with(
            'error',
            'Mã sinh viên không tồn tại trong hệ thống'
        );
    }
    // Tìm nhân viên rảnh
    $nv = NhanVienXuLy::where(
        'TrangThaiOnline',
        1
    )
        ->whereNotIn(
            'MaNV',
            YeuCauDichVu::where(
                'TrangThai',
                'DangXuLy'
            )->pluck('MaNV')
        )
        ->first();
    YeuCauDichVu::create([
        'MaSV' => $request->masv,
        'LoaiDichVu' => $request->loai,
        'NgayGui' => now(),
        'TrangThai' => $nv
            ? 'DangXuLy'
            : 'ChoXuLy',
        'MaNV' => $nv
            ? $nv->MaNV
            : null
    ]);
    event(new DuLieuCapNhat());
    return back()->with(
        'success',
        'Gửi yêu cầu thành công'
    );
    }
}
