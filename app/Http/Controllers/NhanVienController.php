<?php

namespace App\Http\Controllers;

use App\Models\YeuCauDichVu;
use App\Events\DuLieuCapNhat;
use Illuminate\Http\Request;
use App\Models\TaiKhoan;

class NhanVienController extends Controller
{
    public function index()
    {
        if (session('VaiTro') != 'NhanVien') {
            return redirect('/login');
        }
        $maNV = session('MaNV');
        $data = YeuCauDichVu::where(function ($q) use ($maNV) {
            $q->whereNull('MaNV')
                ->orWhere('MaNV', $maNV);
        })
            ->where('TrangThai', '!=', 'HoanThanh')
            ->orderBy('MaYC', 'desc')
            ->get();
        return view(
            'nhanvien',
            compact('data')
        );
    }

    public function api_YC()
    {
        return YeuCauDichVu::where(
            'MaNV',
            session('MaNV')
        )
            ->where(
                'TrangThai',
                '!=',
                'HoanThanh'
            )
            ->orderBy('MaYC', 'desc')
            ->get();
    }

    public function CN_HT($id)
    {
        $maNV = session('MaNV');
        $yc = YeuCauDichVu::findOrFail($id);

        if ($yc->MaNV != $maNV) {
            return back();
        }
        // Hoàn thành yêu cầu hiện tại
        $yc->update([
            'TrangThai' => 'HoanThanh',
            'NgayHoanThanh' => now()
        ]);
        event(new DuLieuCapNhat());
        // Tìm yêu cầu chờ xử lý lâu nhất
        $yeuCauMoi = YeuCauDichVu::where(
            'TrangThai',
            'ChoXuLy'
        )
            ->whereNull('MaNV')
            ->orderBy('MaYC')
            ->first();
        // Tự nhận yêu cầu mới
        if ($yeuCauMoi) {
            $yeuCauMoi->update([
                'MaNV' => $maNV,
                'TrangThai' => 'DangXuLy'
            ]);
            event(new DuLieuCapNhat());
        }
        return redirect('/nhanvien');
    }

    public function da_xu_ly()
    {
        return YeuCauDichVu::where('MaNV', session('MaNV'))
            ->where('TrangThai', 'HoanThanh')
            ->orderByDesc('MaYC')
            ->get();
    }
    
    public function doiMatKhau(Request $request)
    {
        $tk = TaiKhoan::where(
            'MaNV',
            session('MaNV')
        )->first();
        if (!$tk) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy tài khoản'
            ]);
        }
        if ($tk->Password != $request->cu) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu cũ không đúng'
            ]);
        }
        $tk->Password = $request->moi;
        $tk->DaDoiMatKhau = 1;
        $tk->save();
        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }
}
