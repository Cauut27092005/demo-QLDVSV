<?php

namespace App\Http\Controllers;

use App\Models\YeuCauDichVu;
use App\Events\DuLieuCapNhat;
use Illuminate\Http\Request;
use App\Models\TaiKhoan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NhanVienExport;
use App\Models\Users;
use App\Models\LoaiDichVu;
use Illuminate\Support\Facades\DB;

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

    public function layLoaiDV()
    {
        $data = LoaiDichVu::leftJoin(
            'users',
            'loai_dichvu.MaNV',
            '=',
            'users.MaNV'
        )
            ->select(
                'loai_dichvu.MaLoai',
                'loai_dichvu.TenLoai',
                'loai_dichvu.MaNV',
                'users.HoTen'
            )
            ->orderBy('loai_dichvu.MaLoai')
            ->get();
        return response()->json($data);
    }

    public function luuLoaiDV(Request $request)
    {
        $maNV = session('Username');
        DB::beginTransaction();
        try {
            // Bỏ tất cả loại đang phụ trách
            LoaiDichVu::where('MaNV', $maNV)
                ->update([
                    'MaNV' => null
                ]);
            // Nếu không chọn gì
            if (!empty($request->MaLoai)) {
                foreach ($request->MaLoai as $maLoai) {
                    $loai = LoaiDichVu::where('MaLoai', $maLoai)
                        ->lockForUpdate()
                        ->first();
                    if (!$loai) {
                        continue;
                    }
                    // Đã có người khác phụ trách
                    if (
                        $loai->MaNV != null &&
                        $loai->MaNV != $maNV
                    ) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => $loai->TenLoai . ' đã có nhân viên khác phụ trách.'
                        ]);
                    }
                    $loai->MaNV = $maNV;
                    $loai->save();
                }
            }
            DB::commit();
            event(new DuLieuCapNhat());
            return response()->json([
                'success' => true,
                'message' => 'Lưu loại dịch vụ thành công.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function api_YC(Request $request)
    {
        $query = YeuCauDichVu::leftJoin(
            'users',
            'yeucau_dichvu.MaNV',
            '=',
            'users.MaNV'
        )
            ->leftJoin(
                'loai_dichvu',
                'yeucau_dichvu.MaLoai',
                '=',
                'loai_dichvu.MaLoai'
            )
            ->select(
                'yeucau_dichvu.*',
                'users.HoTen as TenNhanVien',
                'loai_dichvu.TenLoai as LoaiDichVu',
                'loai_dichvu.SLA_Gio'
            );
        $maNV = session('Username');
        $query->where(function ($q) use ($maNV) {
            $q->where('loai_dichvu.MaNV', $maNV)
                ->orWhere('yeucau_dichvu.MaNV', $maNV);
        });
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
                $q->where(
                    'yeucau_dichvu.MaSV',
                    'like',
                    "%$keyword%"
                )
                    ->orWhere(
                        'yeucau_dichvu.MaYC',
                        'like',
                        "%$keyword%"
                    )
                    ->orWhere(
                        'loai_dichvu.TenLoai',
                        'like',
                        "%$keyword%"
                    );
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
            new NhanVienExport(),
            'LichSuDaXuLy_' . session('Username') . '.xlsx'
        );
    }

    public function thongKe()
    {
        $maNV = session('Username');
        $cho = YeuCauDichVu::join(
            'loai_dichvu',
            'yeucau_dichvu.MaLoai',
            '=',
            'loai_dichvu.MaLoai'
        )
            ->where('loai_dichvu.MaNV', $maNV)
            ->where('TrangThai', 'ChoXuLy')
            ->count();
        $dang = YeuCauDichVu::where('TrangThai', 'DangXuLy')
            ->where('MaNV', $maNV)
            ->count();
        $tong = YeuCauDichVu::where('TrangThai', 'HoanThanh')
            ->where('MaNV', $maNV)
            ->count();
        return response()->json([
            'cho' => $cho,
            'dang' => $dang,
            'tong' => $tong
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
        $coQuyen = LoaiDichVu::where(
            'MaLoai',
            $yc->MaLoai
        )
            ->where(
                'MaNV',
                session('Username')
            )
            ->exists();
        if (!$coQuyen) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không phụ trách loại dịch vụ này.'
            ]);
        }
        $yc->TrangThai = 'DangXuLy';
        $yc->MaNV = session('Username');
        $yc->NgayNhan = now();
        $yc->save();
        event(new DuLieuCapNhat());
        return response()->json([
            'success' => true,
            'message' => 'Nhận yêu cầu thành công.'
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
        $loai = LoaiDichVu::find($yc->MaLoai);
        $sla = $loai->SLA_Gio;
        $gioXuLy = now()->diffInHours(
            \Carbon\Carbon::parse($yc->NgayNhan)
        );
        $yc->TrangThai = 'HoanThanh';
        $yc->NgayHoanThanh = now();
        $yc->SLA_ApDung = $sla;
        $yc->DatSLA = $gioXuLy <= $sla ? 1 : 0;
        $yc->save();
        event(new DuLieuCapNhat());
        return response()->json([
            'success' => true,
            'message' => 'Đã hoàn thành.'
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
