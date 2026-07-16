<?php

namespace App\Http\Controllers;

use App\Models\YeuCauDichVu;
use App\Events\DuLieuCapNhat;
use Illuminate\Http\Request;
use App\Models\TaiKhoan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\YeuCauExport;
use App\Models\NhanVienXuLy;

class NhanVienController extends Controller
{
    public function index()
    {
        if (session('VaiTro') != 'NhanVien') {
            return redirect('/login');
        }
        $maNV = session('Username');
        $data = YeuCauDichVu::where('MaNV', $maNV)
            ->where('TrangThai', '!=', 'HoanThanh')
            ->orderByDesc('MaYC')
            ->get();
        return view(
            'nhanvien',
            compact('data')
        );
    }

    public function api_YC(Request $request)
    {

        $query = YeuCauDichVu::leftJoin(
            'nhanvien_xuly',
            'yeucau_dichvu.MaNV',
            '=',
            'nhanvien_xuly.MaNV'
        )
            ->select(
                'yeucau_dichvu.*',
                'nhanvien_xuly.HoTen as TenNhanVien'
            );
        switch ($request->tab) {
            case 'xuly':
                $query->where(function ($q) {
                    $q->where('TrangThai', 'ChoXuLy')
                        ->orWhere(function ($q2) {
                            $q2->where('TrangThai', 'DangXuLy')
                                ->where(
                                    'yeucau_dichvu.MaNV',
                                    session('Username')
                                );
                        });
                });
                break;
            case 'lichsu':
                $query->where('TrangThai', 'HoanThanh')
                    ->where(
                        'yeucau_dichvu.MaNV',
                        session('Username')
                    );
                break;
        }
        // ====== TÌM KIẾM ======
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('yeucau_dichvu.MaSV', 'like', "%$keyword%")
                    ->orWhere('yeucau_dichvu.MaYC', 'like', "%$keyword%")
                    ->orWhere('yeucau_dichvu.LoaiDichVu', 'like', "%$keyword%");
            });
        }
        if ($request->filled('tuNgay')) {

            $query->whereDate(
                'NgayGui',
                '>=',
                $request->tuNgay
            );
        }
        if ($request->filled('denNgay')) {
            $query->whereDate(
                'NgayGui',
                '<=',
                $request->denNgay
            );
        }
        return response()->json(
            $query->orderByDesc('MaYC')->paginate(10)
        );
    }

    public function xuatExcel()
    {
        return Excel::download(
            new YeuCauExport(),
            'LichSuDaXuLy_' . session('Username') . '.xlsx'
        );
    }

    public function thongKe()
    {
        $maNV = session('Username');
        return response()->json([
            'cho' => YeuCauDichVu::where(
                'TrangThai',
                'ChoXuLy'
            )->count(),
            'dang' => YeuCauDichVu::where(
                'TrangThai',
                'DangXuLy'
            )
                ->where('MaNV', $maNV)
                ->count(),
            'tong' => YeuCauDichVu::where(
                'TrangThai',
                'HoanThanh'
            )
                ->where('MaNV', $maNV)
                ->count()
        ]);
    }
    public function nhanYeuCau($id)
    {
        $yc = YeuCauDichVu::findOrFail($id);
        if ($yc->TrangThai != 'ChoXuLy') {
            return response()->json([
                'success' => false,
                'message' => 'Yêu cầu đã có người nhận.'
            ]);
        }
        $yc->TrangThai = 'DangXuLy';
        $yc->MaNV = session('Username');
        $yc->save();
        event(new DuLieuCapNhat());
        return response()->json([
            'success' => true,
            'message' => 'Nhận yêu cầu thành công.'
        ]);
    }

    public function tuDongNhan(Request $request)
    {
        $maNV = session('Username');
        $yeuCau = YeuCauDichVu::where('TrangThai', 'ChoXuLy')
            ->orderBy('NgayGui', 'asc')
            ->first();
        if (!$yeuCau) {
            return response()->json([
                'message' => 'Không còn yêu cầu cần xử lý.'
            ], 404);
        }
        $yeuCau->TrangThai = 'DangXuLy';
        $yeuCau->MaNV = $maNV;
        $yeuCau->save();

        return response()->json([
            'message' => 'Đã tự động nhận yêu cầu ' . $yeuCau->MaYC
        ]);
    }

    public function CN_HT($id)
    {
        $yc = YeuCauDichVu::findOrFail($id);

        if ($yc->MaNV != session('Username')) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hoàn thành yêu cầu này.'
            ]);
        }

        $yc->update([
            'TrangThai' => 'HoanThanh',
            'NgayHoanThanh' => now()
        ]);

        event(new DuLieuCapNhat());

        return response()->json([
            'success' => true,
            'message' => 'Đã hoàn thành yêu cầu.'
        ]);
    }
    public function doiMatKhau(Request $request)
    {
        $tk = TaiKhoan::where(
            'Username',
            session('Username')
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
        $tk->save();
        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }
}
