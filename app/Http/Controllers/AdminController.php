<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Events\DuLieuCapNhat;
use Illuminate\Support\Facades\DB;
use App\Models\TkGoogle;

class AdminController extends Controller
{
    public function index()
    {
        if (session('VaiTro') != 'Admin') {
            return redirect('/login');
        }
        return view('admin');
    }
    public function QL_NV()
    {
        if (session('VaiTro') != 'Admin') {
            return redirect('/login');
        }
        $data = Users::all();
        return view(
            'quanly_nhanvien',
            compact('data')
        );
    }
    public function QL_Google()
    {
        if (session('VaiTro') != 'Admin') {
            return redirect('/login');
        }
        return view('quanly_google');
    }
    public function apiGoogle()
    {
        return TkGoogle::leftJoin(
            'users',
            'tk_google.MaNV',
            '=',
            'users.MaNV'
        )
            ->select(
                'tk_google.*',
                'users.Quay'
            )
            ->orderBy('CreatedAt', 'DESC')
            ->get();
    }
    public function taiKhoanGoogle()
    {
        return TkGoogle::orderBy('CreatedAt', 'desc')->get();
    }
    public function duyetGoogle(Request $request)
    {
        $request->validate([
            'MaND' => 'required',
            'MaNV' => 'required',
            'VaiTro' => 'required'
        ]);
        $tk = TkGoogle::findOrFail($request->MaND);
        // Kiểm tra MaNV có tồn tại không
        $user = Users::where('MaNV', $request->MaNV)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Không tìm thấy nhân viên.'
            ], 404);
        }
        $daLienKet = TkGoogle::where('MaNV', $request->MaNV)
            ->where('MaND', '!=', $request->MaND)
            ->exists();
        if ($daLienKet) {
            return response()->json([
                'message' => 'Nhân viên này đã liên kết với tài khoản Google khác.'
            ], 400);
        }
        $tk->update([
            'MaNV' => $request->MaNV,
            'VaiTro' => $request->VaiTro,
            'TrangThai' => 'HoatDong'
        ]);
        event(new DuLieuCapNhat(
            'GoogleDuyet',
            [
                'MaND' => $tk->MaND,
                'MaNV' => $tk->MaNV
            ]
        ));
        return response()->json([
            'success' => true
        ]);
    }
    public function tuChoiGoogle(Request $request)
    {
        $request->validate([
            'MaND' => 'required'
        ]);
        $tk = TkGoogle::findOrFail($request->MaND);
        $tk->update([
            'MaNV' => null,
            'VaiTro' => null,
            'TrangThai' => 'TuChoi'
        ]);
        event(new DuLieuCapNhat(
            'GoogleTuChoi',
            [
                'MaND' => $tk->MaND
            ]
        ));
        return response()->json([
            'success' => true,
            'message' => 'Đã từ chối tài khoản Google.'
        ]);
    }
    public function nhanVien()
    {
        return Users::leftJoin(
            'tk_google',
            'users.MaNV',
            '=',
            'tk_google.MaNV'
        )
            ->select(
                'users.MaNV',
                'users.HoTen',
                'users.Quay',
                'tk_google.Email',
                'tk_google.VaiTro',
                'tk_google.TrangThai'
            )
            ->get();
    }
    public function addNV(Request $request)
    {
        try {
            Users::create([
                'MaNV' => $request->MaNV,
                'HoTen' => $request->HoTen,
                'Quay' => $request->Quay,
            ]);
            event(new DuLieuCapNhat(
                'ThemNhanVien',
                ['MaNV' => $request->MaNV]
            ));
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateNV(Request $request)
    {
        DB::beginTransaction();
        try {
            Users::where('MaNV', $request->MaNV)
                ->update([
                    'HoTen' => $request->HoTen,
                    'Quay' => $request->Quay
                ]);
            TkGoogle::where('MaNV', $request->MaNV)
                ->update([
                    'VaiTro' => $request->VaiTro
                ]);
            DB::commit();
            event(new DuLieuCapNhat(
                'SuaNhanVien',
                ['MaNV' => $request->MaNV]
            ));
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function deleteNV($id)
    {
        DB::beginTransaction();
        try {
            TkGoogle::where('MaNV', $id)
                ->update([
                    'MaNV' => null,
                    'VaiTro' => null,
                    'TrangThai' => 'TuChoi'
                ]);
            Users::where('MaNV', $id)->delete();
            DB::commit();
            event(new DuLieuCapNhat(
                'XoaNhanVien',
                ['MaNV' => $id]
            ));
            return response()->json(true);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
}
