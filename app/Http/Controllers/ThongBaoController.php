<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;

class ThongBaoController extends Controller
{
    public function index(){
        return view('bang_thongbao');
    }

    public function api_TB(){
         return YeuCauDichVu::whereIn(
        'TrangThai',
        ['ChoXuLy', 'DangXuLy']
    )
        ->orderByRaw("
        CASE
            WHEN TrangThai='DangXuLy' THEN 1
            WHEN TrangThai='ChoXuLy' THEN 2
        END
    ")
        ->orderBy('MaYC', 'desc')
        ->get();
    }
}
