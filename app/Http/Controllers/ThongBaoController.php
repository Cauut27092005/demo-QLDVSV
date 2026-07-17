<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;

class ThongBaoController extends Controller
{
    public function index()
    {
        return view('bang_thongbao');
    }

    public function api_TB()
    {
        return YeuCauDichVu::leftJoin(
            'nhanvien_xuly',
            'yeucau_dichvu.MaNV',
            '=',
            'nhanvien_xuly.MaNV'
        )
            ->leftJoin(
                'loai_dichvu',
                'yeucau_dichvu.MaLoai',
                '=',
                'loai_dichvu.MaLoai'
            )
            ->select(
                'yeucau_dichvu.*',
                'nhanvien_xuly.Quay',
                'loai_dichvu.TenLoai as LoaiDichVu'
            )
            ->whereIn(
                'yeucau_dichvu.TrangThai',
                ['ChoXuLy', 'DangXuLy']
            )
            ->orderByRaw("
            CASE
                WHEN yeucau_dichvu.TrangThai='DangXuLy' THEN 1
                WHEN yeucau_dichvu.TrangThai='ChoXuLy' THEN 2
            END
        ")
            ->orderByDesc('yeucau_dichvu.MaYC')
            ->get();
    }
}
