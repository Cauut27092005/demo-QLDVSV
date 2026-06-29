<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;

class HomeController extends Controller
{
    // Hiển thị trang sinh viên
    public function index()
    {
        return view('home');
    }

    // Gửi yêu cầu
    public function store(Request $request)
    {
        $request->validate([
            'masv' => 'required',
            'loai' => 'required',
        ]);

        YeuCauDichVu::create([
            'MaSV' => $request->masv,
            'LoaiDichVu' => $request->loai,
            'TrangThai' => 'ChoXuLy',
            'NgayGui' => now(),
            'MaNV' => null
        ]);

        return redirect('/home')->with('success', 'Gửi yêu cầu thành công!');
    }
}