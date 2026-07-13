<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\YeuCauExport;

class TruongPhongController extends Controller
{
    public function index()
    {
        if(session('VaiTro')!='TruongPhong'){
            return redirect('/login');
        }

        return view('truongphong');
    }

    public function api()
    {
        return YeuCauDichVu::
            leftJoin(
                'nhanvien_xuly',
                'yeucau_dichvu.MaNV',
                '=',
                'nhanvien_xuly.MaNV'
            )
            ->select(
                'yeucau_dichvu.*',
                'nhanvien_xuly.HoTen',
                'nhanvien_xuly.Quay'
            )
            ->orderByDesc('MaYC')
            ->get();
    }

    public function excel()
    {
        return Excel::download(
            new YeuCauExport(),
            'BaoCao.xlsx'
        );
    }
}
