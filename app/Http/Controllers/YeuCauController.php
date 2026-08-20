<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;
use Illuminate\Support\Facades\Http;
use App\Events\DuLieuCapNhat;

class YeuCauController extends Controller
{
    public function store(Request $request)
    {
        // ==========================
        // Kiểm tra dữ liệu nhập
        // ==========================
        $request->validate(
            [
                'masv' => 'required',
                'loai' => 'required',
            ],
            [
                'masv.required' => 'Vui lòng nhập mã sinh viên.',
                'loai.required' => 'Vui lòng chọn loại dịch vụ.',
            ]
        );
        // ==========================
        // Kiểm tra IP
        // ==========================
        $ip = $request->ip();
        if (
            $ip !== '127.0.0.1' &&
            $ip !== '::1' &&
            !str_starts_with($ip, '10.82.')
        ) {
            return back()->with(
                'error',
                'Hệ thống chỉ được sử dụng trong khu vực của trường.'
            );
        }
        // ==========================
        // Kiểm tra sinh viên
        // ==========================
        try {
            $response = Http::timeout(3)->get(
                'http://localhost:3000/sinhvien',
                [
                    'MaSV' => $request->masv
                ]
            );
            $sinhVien = $response->json();
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Không kết nối được hệ thống kiểm tra mã sinh viên (localhost:3000).'
            );
        }
        if (!is_array($sinhVien) || count($sinhVien) == 0) {
            return back()->with(
                'error',
                'Mã sinh viên không tồn tại trong hệ thống.'
            );
        }
        // ==========================
        // Lưu yêu cầu
        // ==========================
        $yc = YeuCauDichVu::create([
            'MaSV'      => $request->masv,
            'MaLoai'    => $request->loai,
            'NgayGui'   => now(),
            'TrangThai' => 'ChoXuLy',
            'MaNV'      => null
        ]);
        // ==========================
        // Gửi sự kiện realtime
        // ==========================
        try {
            event(new DuLieuCapNhat(
                'TaoYeuCau',
                [
                    'MaYC' => $yc->MaYC,
                    'MaLoai' => $yc->MaLoai,
                    'TrangThai' => $yc->TrangThai
                ]
            ));
        } catch (\Throwable $e) {
            report($e);
        }
        return back()->with(
            'success',
            'Gửi yêu cầu thành công.'
        );
    }
}
