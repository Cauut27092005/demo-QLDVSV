<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuCauDichVu;
use App\Models\NhanVienXuLy;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\YeuCauExport;
use App\Models\LoaiDichVu;

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
            "tongYC" => YeuCauDichVu::count(),
            "choXuLy" => YeuCauDichVu::where(
                "TrangThai",
                "ChoXuLy"
            )->count(),
            "dangXuLy" => YeuCauDichVu::where(
                "TrangThai",
                "DangXuLy"
            )->count(),
            "hoanThanh" => YeuCauDichVu::where(
                "TrangThai",
                "HoanThanh"
            )->count(),
            "tongNhanVien" => NhanVienXuLy::count(),
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
            'nhanvien_xuly',
            'yeucau_dichvu.MaNV',
            '=',
            'nhanvien_xuly.MaNV'
        )
            ->leftJoin(
                'loai_dichvu',
                'yeucau_dichvu.MaLoai',
                '=',
                'loai_dichvu.MaLoai'
            )
            ->select(
                'yeucau_dichvu.*',
                'nhanvien_xuly.HoTen as TenNhanVien',
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
        // Trạng thái
        // =======================
        if ($request->filled('trangThai')) {
            $query->where(
                'TrangThai',
                $request->trangThai
            );
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
                ->paginate(8)
        );
    }
    /*biểu đồ*/
    public function chartTrangThai()
    {
        return response()->json([
            'ChoXuLy' => YeuCauDichVu::where('TrangThai', 'ChoXuLy')->count(),
            'DangXuLy' => YeuCauDichVu::where('TrangThai', 'DangXuLy')->count(),
            'HoanThanh' => YeuCauDichVu::where('TrangThai', 'HoanThanh')->count(),
        ]);
    }
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

            NhanVienXuLy::leftJoin(
                "yeucau_dichvu",
                "nhanvien_xuly.MaNV",
                "=",
                "yeucau_dichvu.MaNV"
            )

                ->selectRaw("
            nhanvien_xuly.MaNV,
            nhanvien_xuly.HoTen,
            COALESCE(
                SUM(
                    CASE
                    WHEN TrangThai='DangXuLy'

                    THEN 1
                    ELSE 0
                    END
                )
            ,0)
            as DangXuLy,
            COALESCE(
                SUM(
                    CASE
                    WHEN TrangThai='HoanThanh'
                    THEN 1
                    ELSE 0
                    END
                )
            ,0)
            as HoanThanh,
            COUNT(
                yeucau_dichvu.MaYC
            )
            as Tong
        ")
                ->groupBy(
                    "nhanvien_xuly.MaNV",
                    "nhanvien_xuly.HoTen"
                )
                ->orderByDesc("Tong")
                ->get()
        );
    }
    /*top nhân viên*/
    public function topNhanVien()
    {
        return response()->json(
            NhanVienXuLy::leftJoin(
                "yeucau_dichvu",
                "nhanvien_xuly.MaNV",
                "=",
                "yeucau_dichvu.MaNV"
            )
                ->selectRaw("
            nhanvien_xuly.MaNV,
            nhanvien_xuly.HoTen,
            COUNT(
                CASE
                WHEN TrangThai='HoanThanh'
                THEN 1
                END
            )
            as Tong
        ")
                ->groupBy(
                    "nhanvien_xuly.MaNV",
                    "nhanvien_xuly.HoTen"
                )
                ->orderByDesc("Tong")
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
    public function excel()
    {
        return Excel::download(
            new YeuCauExport(),
            'BaoCaoTruongPhong.xlsx'

        );
    }
}
