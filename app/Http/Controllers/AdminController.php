<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
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

    public function nhanVien()
    {
        return Users::leftJoin(
            'taikhoan',
            'users.MaNV',
            '=',
            'taikhoan.Username'
        )
            ->select(
                'users.MaNV',
                'users.HoTen',
                'users.Quay',
                'taikhoan.VaiTro'
            )
            ->get();
    }
    public function addNV(Request $request)
    {
        DB::beginTransaction();
        try {
            Users::create([
                'MaNV' => $request->MaNV,
                'HoTen' => $request->HoTen,
                'Quay' => $request->Quay,
            ]);
            TaiKhoan::create([
                'Username' => $request->MaNV,
                'Password' => '123456',
                'VaiTro' => $request->VaiTro
            ]);
            DB::commit();
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

    public function updateNV(Request $request)
    {
        Users::where('MaNV', $request->MaNV)
            ->update([
                'HoTen' => $request->HoTen,
                'Quay' => $request->Quay
            ]);
        TaiKhoan::where('Username', $request->MaNV)
            ->update([
                'VaiTro' => $request->VaiTro
            ]);
        return response()->json([
            'success' => true
        ]);
    }

    public function deleteNV($id)
    {
        DB::beginTransaction();
        try {
            TaiKhoan::where('Username', $id)->delete();
            Users::where('MaNV', $id)->delete();
            DB::commit();
            return response()->json(true);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
    public function resetPassword($maNV)
    {
        TaiKhoan::where('Username', $maNV)
            ->update([
                'Password' => '123456',
            ]);
        return response()->json([
            'success' => true
        ]);
    }
}
