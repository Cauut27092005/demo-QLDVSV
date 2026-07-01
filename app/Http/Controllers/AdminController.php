<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhanVienXuLy;
use App\Models\YeuCauDichVu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\TaiKhoan;

class AdminController extends Controller
{
    public function index()
    {
        if (session('VaiTro') != 'Admin') {
            return redirect('/login');
        }
        return view('admin');
    }

    public function api_admin()
    {
        return [
            'tongNV' => NhanVienXuLy::count(),

            'online' => NhanVienXuLy::where(
                'TrangThaiOnline',
                1
            )->count(),

            'tongYC' => YeuCauDichVu::count(),

            'choXuLy' => YeuCauDichVu::where(
                'TrangThai',
                'ChoXuLy'
            )->count(),

            'dangXuLy' => YeuCauDichVu::where(
                'TrangThai',
                'DangXuLy'
            )->count(),

            'hoanThanh' => YeuCauDichVu::where(
                'TrangThai',
                'HoanThanh'
            )->count(),

            'nhanViens' => NhanVienXuLy::all(),

            'yeuCaus' => YeuCauDichVu::orderByDesc('MaYC')->get(),

            'dangXuLys' => YeuCauDichVu::where(
                'TrangThai',
                'DangXuLy'
            )->orderByDesc('MaYC')->get(),

            'hoanThanhs' => YeuCauDichVu::where(
                'TrangThai',
                'HoanThanh'
            )->orderByDesc('MaYC')->get(),
        ];
    }

    public function api_THK_NV(Request $request)
    {
        $query = DB::table('yeucau_dichvu')
            ->join(
                'nhanvien_xuly',
                'yeucau_dichvu.MaNV',
                '=',
                'nhanvien_xuly.MaNV'
            )
            ->select(
                'nhanvien_xuly.MaNV',
                'nhanvien_xuly.HoTen',
                DB::raw('COUNT(*) as SoLuong')
            )
            ->where('TrangThai', 'HoanThanh');

        if ($request->tuNgay && $request->denNgay) {
            $query->whereBetween(
                'NgayHoanThanh',
                [
                    $request->tuNgay . ' 00:00:00',
                    $request->denNgay . ' 23:59:59'
                ]
            );
        }
        return $query
            ->groupBy(
                'nhanvien_xuly.MaNV',
                'nhanvien_xuly.HoTen'
            )
            ->orderByDesc('SoLuong')
            ->get();
    }

    public function api_CHT_NV($maNV)
    {
        return YeuCauDichVu::where('MaNV', $maNV)
            ->where('TrangThai', 'HoanThanh')
            ->select(
                'MaYC',
                'MaSV',
                'LoaiDichVu',
                'NgayGui',
                'NgayHoanThanh'
            )
            ->get();
    }

    public function QL_NV()
    {
        if (session('VaiTro') != 'Admin') {
            return redirect('/login');
        }
        $data = NhanVienXuLy::all();
        return view(
            'quanly_nhanvien',
            compact('data')
        );
    }

    public function dashboard()
    {
        return [
            'tongNV' => NhanVienXuLy::count(),

            'online' => NhanVienXuLy::where(
                'TrangThaiOnline',
                1
            )->count(),
            'tongYC' => YeuCauDichVu::count(),

            'choXuLy' => YeuCauDichVu::where(
                'TrangThai',
                'ChoXuLy'
            )->count(),
            'dangXuLy' => YeuCauDichVu::where(
                'TrangThai',
                'DangXuLy'
            )->count(),
            'hoanThanh' => YeuCauDichVu::where(
                'TrangThai',
                'HoanThanh'
            )->count(),
        ];
    }

    public function nhanVien()
    {
        return NhanVienXuLy::all();
    }

    public function yeuCau()
    {
        return YeuCauDichVu::all();
    }

    public function dangXuLy()
    {
        return YeuCauDichVu::where(
            'TrangThai',
            'DangXuLy'
        )->get();
    }

    public function hoanThanh()
    {
        return YeuCauDichVu::where(
            'TrangThai',
            'HoanThanh'
        )->get();
    }

    public function addNV(Request $request)
    {
        DB::beginTransaction();
        try {
            NhanVienXuLy::create([
                'MaNV' => $request->MaNV,
                'HoTen' => $request->HoTen,
                'BoPhan' => $request->BoPhan,
                'TrangThaiOnline' => 0
            ]);
            TaiKhoan::create([
                'Username' => $request->MaNV,
                'Password' => '123456',
                'VaiTro' => 'NhanVien',
                'MaNV' => $request->MaNV,
                'DaDoiMatKhau' => 0
            ]);
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function updateNV(Request $request)
    {
        NhanVienXuLy::where(
            'MaNV',
            $request->MaNV
        )->update([
            'HoTen' => $request->HoTen,
            'BoPhan' => $request->BoPhan

        ]);
        return response()->json(true);
    }

    public function deleteNV($id)
    {
        NhanVienXuLy::where(
            'MaNV',
            $id
        )->delete();
        return response()->json(true);
    }
    public function resetPassword($maNV)
    {
        TaiKhoan::where('MaNV', $maNV)
            ->update([
                'Password' => '123456',
                'DaDoiMatKhau' => 0
            ]);

        return response()->json([
            'success' => true
        ]);
    }
}
