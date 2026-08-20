<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;
use App\Models\Users;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TopNhanVienExport;
use App\Exports\YeuCauExport;
use App\Models\LoaiDichVu;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Events\DuLieuCapNhat;

class TruongPhongController extends Controller
{
    public function index()
    {
        if (session('VaiTro') != 'TruongPhong') {
            return redirect('/login');
        }
        return view('truongphong');
    }
    /*Dashboard*/
    public function dashboard()
    {
        return response()->json([
            "tongYC" => YeuCauDichVu::whereMonth("NgayGui", now()->month)
                ->whereYear("NgayGui", now()->year)
                ->count(),
            "choXuLy" => YeuCauDichVu::where("TrangThai", "ChoXuLy")
                ->whereMonth("NgayGui", now()->month)
                ->whereYear("NgayGui", now()->year)
                ->count(),
            "dangXuLy" => YeuCauDichVu::where("TrangThai", "DangXuLy")
                ->whereMonth("NgayGui", now()->month)
                ->whereYear("NgayGui", now()->year)
                ->count(),
            "hoanThanh" => YeuCauDichVu::where("TrangThai", "HoanThanh")
                ->whereMonth("NgayGui", now()->month)
                ->whereYear("NgayGui", now()->year)
                ->count(),
            "homNay" => YeuCauDichVu::whereDate(
                "NgayGui",
                today()
            )->count(),
            "hoanThanhHomNay" => YeuCauDichVu::whereDate(
                "NgayHoanThanh",
                today()
            )->count()
        ]);
    }
    /*Danh sách yêu cầu*/
    public function yeuCau(Request $request)
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
                'loai_dichvu.TenLoai as LoaiDichVu'
            );
        // =======================
        // Tìm kiếm
        // =======================
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where(
                    'yeucau_dichvu.MaYC',
                    'like',
                    "%$keyword%"
                )
                    ->orWhere(
                        'yeucau_dichvu.MaSV',
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
        // =======================
        // Lọc theo loại dịch vụ
        // =======================
        if ($request->filled('maLoai')) {
            $query->where(
                'yeucau_dichvu.MaLoai',
                $request->maLoai
            );
        }
        // =======================
        // Trạng thái: Đã xử lý / Hủy
        // =======================
        if ($request->filled('trangThai')) {
            if ($request->trangThai === 'DaXuLy') {
                $query->whereIn(
                    'yeucau_dichvu.TrangThai',
                    ['HoanThanh']
                );
            } elseif ($request->trangThai === 'Huy') {
                $query->where(
                    'yeucau_dichvu.TrangThai',
                    'Huy'
                );
            }
        }
        // =======================
        // Từ ngày
        // =======================
        if ($request->filled('tuNgay')) {

            $query->whereDate(
                'NgayGui',
                '>=',
                $request->tuNgay
            );
        }
        // =======================
        // Đến ngày
        // =======================
        if ($request->filled('denNgay')) {
            $query->whereDate(
                'NgayGui',
                '<=',
                $request->denNgay
            );
        }
        return response()->json(
            $query
                ->orderByDesc('MaYC')
                ->simplePaginate(10)
        );
    }
    public function dsSLA()
    {
        return response()->json(
            LoaiDichVu::select(
                'MaLoai',
                'TenLoai',
                'SLA_Phut'
            )->get()
        );
    }
    public function capNhatSLA(Request $request)
    {
        $request->validate([
            'MaLoai' => 'required',
            'SLA_Phut' => 'required|integer|min:1'
        ]);
        LoaiDichVu::where(
            'MaLoai',
            $request->MaLoai
        )->update([
            'SLA_Phut' => $request->SLA_Phut
        ]);
        event(new DuLieuCapNhat(
            'CapNhatSLA',
            [
                'MaLoai' => $request->MaLoai,
                'SLA_Phut' => $request->SLA_Phut
            ]
        ));
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật SLA thành công.'
        ]);
    }
    public function xuatBaoCao(Request $request)
    {
        $tong = YeuCauDichVu::count();
        $cho = YeuCauDichVu::where(
            'TrangThai',
            'ChoXuLy'
        )->count();
        $dang = YeuCauDichVu::where(
            'TrangThai',
            'DangXuLy'
        )->count();
        $hoanThanh = YeuCauDichVu::where(
            'TrangThai',
            'HoanThanh'
        )->count();
        $tyLe = 0;
        if ($tong > 0) {
            $tyLe = round(
                $hoanThanh * 100 / $tong,
                2
            );
        }
        //==============================
        // Theo loại dịch vụ
        //==============================
        $loaiDichVu = DB::table('loai_dichvu')
            ->leftJoin(
                'yeucau_dichvu',
                'loai_dichvu.MaLoai',
                '=',
                'yeucau_dichvu.MaLoai'
            )
            ->selectRaw('
            loai_dichvu.TenLoai,
            COUNT(yeucau_dichvu.MaYC) as Tong
            ')
            ->groupBy(
                'loai_dichvu.MaLoai',
                'loai_dichvu.TenLoai'
            )
            ->orderBy(
                'loai_dichvu.MaLoai'
            )
            ->get();
        //==============================
        // Nhân viên
        //==============================
        $nhanVien = DB::table('users')
            ->leftJoin(
                'tk_google',
                'users.MaNV',
                '=',
                'tk_google.MaNV'
            )
            ->leftJoin(
                'yeucau_dichvu',
                'users.MaNV',
                '=',
                'yeucau_dichvu.MaNV'
            )
            ->where(
                'tk_google.VaiTro',
                'NhanVien'
            )
            ->selectRaw('
                users.MaNV,
                users.HoTen,
                COUNT(
                    CASE
                    WHEN yeucau_dichvu.TrangThai="HoanThanh"
                    THEN 1
                    END
                ) as HoanThanh,
                COUNT(
                    CASE
                    WHEN yeucau_dichvu.TrangThai="HoanThanh"
                    AND yeucau_dichvu.DatSLA=1
                    THEN 1
                    END
                ) as DatSLA,
                COUNT(
                    CASE
                    WHEN yeucau_dichvu.TrangThai="HoanThanh"
                    AND yeucau_dichvu.DatSLA=0
                    THEN 1
                    END
            ) as QuaSLA
            ')
            ->groupBy(
                'users.MaNV',
                'users.HoTen'
            )
            ->get();
        //==============================
        // Quá SLA
        //==============================
        $quaHan = DB::table('yeucau_dichvu')
            ->leftJoin(
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
            ->where(
                'yeucau_dichvu.TrangThai',
                'HoanThanh'
            )
            ->where(
                'yeucau_dichvu.DatSLA',
                0
            )
            ->select(
                'yeucau_dichvu.MaYC',
                'yeucau_dichvu.MaSV',
                'users.HoTen',
                'loai_dichvu.TenLoai'
            )
            ->get();
        $pdf = Pdf::loadView(
            'truongphong.report',
            compact(
                'tong',
                'cho',
                'dang',
                'hoanThanh',
                'tyLe',
                'loaiDichVu',
                'nhanVien',
                'quaHan'
            )
        );
        $pdf->setPaper(
            'a4',
            'portrait'
        );
        return $pdf->download(
            'BaoCaoTruongPhong_' . date('Ymd_His') . '.pdf'
        );
    }
    /*biểu đồ*/
    public function chartLoaiDichVu()
    {
        return response()->json(
            LoaiDichVu::leftJoin(
                'yeucau_dichvu',
                'loai_dichvu.MaLoai',
                '=',
                'yeucau_dichvu.MaLoai'
            )
                ->selectRaw("
                    loai_dichvu.TenLoai,
                    COUNT(yeucau_dichvu.MaYC) as Tong
                ")
                ->groupBy(
                    'loai_dichvu.MaLoai',
                    'loai_dichvu.TenLoai'
                )
                ->orderBy(
                    'loai_dichvu.MaLoai'
                )
                ->get()
        );
    }
    /*Thống kê nhân viên*/
    public function thongKe()
    {
        return response()->json(
            Users::leftJoin(
                'tk_google',
                'users.MaNV',
                '=',
                'tk_google.MaNV'
            )
                ->leftJoin(
                    'yeucau_dichvu',
                    'users.MaNV',
                    '=',
                    'yeucau_dichvu.MaNV'
                )
                ->where('tk_google.VaiTro', 'NhanVien')
                ->selectRaw("
                    users.MaNV,
                    users.HoTen,
                    COUNT(
                        CASE
                        WHEN yeucau_dichvu.TrangThai='HoanThanh'
                        THEN 1
                        END
                    ) as HoanThanh,
                    COUNT(
                        CASE
                        WHEN yeucau_dichvu.TrangThai='HoanThanh'
                        AND yeucau_dichvu.DatSLA=1
                        THEN 1
                        END
                    ) as DatSLA,
                    COUNT(
                        CASE
                        WHEN yeucau_dichvu.TrangThai='HoanThanh'
                        AND yeucau_dichvu.DatSLA=0
                        THEN 1
                        END
                    ) as QuaSLA
                ")
                ->groupBy(
                    'users.MaNV',
                    'users.HoTen'
                )
                ->get()
                ->map(function ($item) {
                    $item->TyLe =
                        $item->HoanThanh == 0
                        ? 0
                        : round($item->DatSLA * 100 / $item->HoanThanh, 1);

                    return $item;
                })
        );
    }
    /*top nhân viên*/
    public function topNhanVien()
    {
        return response()->json(
            Users::leftJoin(
                'tk_google',
                'users.MaNV',
                '=',
                'tk_google.MaNV'
            )
                ->leftJoin(
                    'yeucau_dichvu',
                    'users.MaNV',
                    '=',
                    'yeucau_dichvu.MaNV'
                )
                ->where('tk_google.VaiTro', 'NhanVien')
                ->selectRaw("
                    users.MaNV,
                    users.HoTen,
                    COUNT(
                        CASE
                        WHEN yeucau_dichvu.TrangThai='HoanThanh'
                        THEN 1
                        END
                    ) as Tong
                ")
                ->groupBy(
                    'users.MaNV',
                    'users.HoTen'
                )
                ->orderByDesc('Tong')
                ->limit(5)
                ->get()
        );
    }
    /*Chi tiết nhân viên*/
    public function chiTiet($maNV)
    {
        return response()->json(
            YeuCauDichVu::leftJoin(
                'loai_dichvu',
                'yeucau_dichvu.MaLoai',
                '=',
                'loai_dichvu.MaLoai'
            )
                ->select(
                    'yeucau_dichvu.*',
                    'loai_dichvu.TenLoai as LoaiDichVu'
                )
                ->where(
                    'yeucau_dichvu.MaNV',
                    $maNV
                )
                ->orderByDesc('NgayGui')
                ->get()
        );
    }
    /*Xuất Excel */
    public function excelTopNhanVien()
    {
        return Excel::download(
            new TopNhanVienExport(),
            'TopNhanVien.xlsx'
        );
    }
    public function excelYeuCau()
    {
        return Excel::download(
            new YeuCauExport(),
            'DanhSachYeuCau.xlsx'
        );
    }
}
