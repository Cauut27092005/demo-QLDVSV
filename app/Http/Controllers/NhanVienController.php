<?php

namespace App\Http\Controllers;

use App\Models\YeuCauDichVu;
use App\Events\DuLieuCapNhat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NhanVienExport;
use App\Models\Users;
use App\Models\LoaiDichVu;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NhanVienController extends Controller
{
    public function index()
    {
        if (session('VaiTro') != 'NhanVien') {
            return redirect('/login');
        }
        $maNV = session('MaNV');
        $data = YeuCauDichVu::where('MaNV', $maNV)
            ->whereIn('TrangThai', ['DangXuLy', 'ChoXuLy'])
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
        $maNV = session('MaNV');
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
            try {
                event(new DuLieuCapNhat(
                    'LoaiDichVu',
                    ['MaNV' => $maNV]
                ));
            } catch (\Throwable $e) {
                report($e);
            }
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
                'loai_dichvu.TenLoai as LoaiDichVu'
            );
        switch ($request->tab) {
            case 'xuly':
                // Lấy các loại dịch vụ nhân viên đang phụ trách
                $maLoai = LoaiDichVu::where('MaNV', session('MaNV'))
                    ->pluck('MaLoai');
                $query->where(function ($q) use ($maLoai) {
                    // Nếu chưa chọn loại dịch vụ nào -> hiện tất cả yêu cầu chờ xử lý
                    if ($maLoai->isEmpty()) {
                        $q->where('TrangThai', 'ChoXuLy');
                    } else {
                        // Đã chọn loại dịch vụ -> chỉ hiện các yêu cầu thuộc loại đó
                        $q->where(function ($q1) use ($maLoai) {
                            $q1->where('TrangThai', 'ChoXuLy')
                                ->whereIn('yeucau_dichvu.MaLoai', $maLoai);
                        });
                    }
                    // Luôn hiện các yêu cầu mà chính nhân viên đang xử lý
                    $q->orWhere(function ($q2) {
                        $q2->where('TrangThai', 'DangXuLy')
                            ->where('yeucau_dichvu.MaNV', session('MaNV'));
                    });
                });
                break;
            case 'lichsu':
                $query->whereIn(
                    'TrangThai',
                    ['HoanThanh', 'Huy']
                )
                    ->where(
                        'yeucau_dichvu.MaNV',
                        session('MaNV')
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
        $query->orderByRaw("
            CASE
            WHEN TrangThai = 'DangXuLy'
            AND yeucau_dichvu.MaNV = ?
            THEN 0
            ELSE 1
            END
        ", [session('MaNV')])
            ->orderByDesc('MaYC');
        return response()->json(
            $query->simplePaginate(10)
        );
    }
    public function xuatExcel()
    {
        return Excel::download(
            new NhanVienExport(),
            'LichSuDaXuLy_' . session('MaNV') . '.xlsx'
        );
    }
    public function thongKe()
    {
        $maNV = session('MaNV');
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
        // Yêu cầu đã có người nhận
        if ($yc->TrangThai != 'ChoXuLy') {
            return response()->json([
                'success' => false,
                'message' => 'Yêu cầu đã có người nhận.'
            ]);
        }
        // Danh sách loại dịch vụ nhân viên đang phụ trách
        $dsLoai = LoaiDichVu::where('MaNV', session('MaNV'))
            ->pluck('MaLoai');
        // Nếu đã chọn loại dịch vụ thì chỉ được nhận đúng loại
        if (
            $dsLoai->isNotEmpty() &&
            !$dsLoai->contains($yc->MaLoai)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không phụ trách loại dịch vụ này.'
            ]);
        }
        // Nhận yêu cầu
        $yc->TrangThai = 'DangXuLy';
        $yc->MaNV = session('MaNV');
        $yc->NgayNhan = now();
        // Lưu SLA của loại dịch vụ tại thời điểm nhận
        $loai = LoaiDichVu::find($yc->MaLoai);
        $yc->SLA_ApDung = $loai ? $loai->SLA_Phut : 60;
        $yc->save();
        try {
            event(new DuLieuCapNhat(
                'NhanYeuCau',
                [
                    'MaYC' => $yc->MaYC,
                    'MaNV' => $yc->MaNV,
                    'MaLoai' => $yc->MaLoai
                ]
            ));
        } catch (\Throwable $e) {
            report($e);
        }
        return response()->json([
            'success' => true,
            'message' => 'Nhận yêu cầu thành công.'
        ]);
    }
    public function tuDongNhan()
    {
        $maNV = session('MaNV');
        // Các loại dịch vụ nhân viên đang phụ trách
        $dsLoai = LoaiDichVu::where('MaNV', $maNV)
            ->pluck('MaLoai');
        $query = YeuCauDichVu::where('TrangThai', 'ChoXuLy');
        // Nếu nhân viên đã chọn loại dịch vụ
        // thì chỉ nhận các ticket thuộc loại mình phụ trách
        if ($dsLoai->isNotEmpty()) {
            $query->whereIn('MaLoai', $dsLoai);
        }
        // Lấy ticket CHƯA ĐƯỢC NHẬN lâu nhất
        $yc = $query
            ->orderBy('NgayGui', 'asc')
            ->first();
        if (!$yc) {
            return response()->json([
                'success' => false,
                'message' => 'Không còn yêu cầu để nhận.'
            ]);
        }
        // Nhận yêu cầu
        $yc->TrangThai = 'DangXuLy';
        $yc->MaNV = $maNV;
        $yc->NgayNhan = now();
        // Lưu SLA tại thời điểm nhận
        $loai = LoaiDichVu::find($yc->MaLoai);
        $yc->SLA_ApDung = $loai ? $loai->SLA_Phut : 60;
        $yc->save();
        // Realtime
        try {
            event(new DuLieuCapNhat(
                'NhanYeuCau',
                [
                    'MaYC' => $yc->MaYC,
                    'MaNV' => $yc->MaNV,
                    'MaLoai' => $yc->MaLoai
                ]
            ));
        } catch (\Throwable $e) {
            report($e);
        }
        return response()->json([
            'success' => true,
            'message' => 'Đã tự động nhận yêu cầu #' . $yc->MaYC
        ]);
    }
    public function CN_HT($id)
    {
        $yc = YeuCauDichVu::findOrFail($id);
        if ($yc->MaNV != session('MaNV')) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hoàn thành yêu cầu này.'
            ]);
        }
        $ngayHoanThanh = now();
        $datSLA = null;
        if ($yc->NgayNhan && $yc->SLA_ApDung) {
            $soPhut = $yc->NgayNhan->diffInMinutes($ngayHoanThanh);
            $datSLA = $soPhut <= $yc->SLA_ApDung;
        }
        $yc->update([
            'TrangThai' => 'HoanThanh',
            'NgayHoanThanh' => $ngayHoanThanh,
            'DatSLA' => $datSLA
        ]);
        try {
            event(new DuLieuCapNhat(
                'HoanThanh',
                [
                    'MaYC' => $yc->MaYC,
                    'MaNV' => $yc->MaNV,
                    'DatSLA' => $datSLA
                ]
            ));
        } catch (\Throwable $e) {
            report($e);
        }
        return response()->json([
            'success' => true,
            'message' => 'Đã hoàn thành yêu cầu.'
        ]);
    }
    public function huyYeuCau($id)
    {
        $yc = YeuCauDichVu::findOrFail($id);
        // Chỉ nhân viên đang nhận ticket mới được hủy
        if ($yc->MaNV != session('MaNV')) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy yêu cầu này.'
            ], 403);
        }
        // Chỉ được hủy khi đang xử lý
        if ($yc->TrangThai != 'DangXuLy') {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể hủy yêu cầu đang xử lý.'
            ], 400);
        }
        $yc->update([
            'TrangThai' => 'Huy',
            'DatSLA' => null
        ]);
        try {
            event(new DuLieuCapNhat(
                'HuyYeuCau',
                [
                    'MaYC' => $yc->MaYC,
                    'MaNV' => $yc->MaNV
                ]
            ));
        } catch (\Throwable $e) {
            report($e);
        }
        return response()->json([
            'success' => true,
            'message' => 'Đã hủy yêu cầu.'
        ]);
    }
    public function canhBaoSLA()
    {
        $maNV = session('MaNV');
        $ds = YeuCauDichVu::where('MaNV', $maNV)
            ->where('TrangThai', 'DangXuLy')
            ->get();
        $ketQua = [];
        foreach ($ds as $yc) {
            if (!$yc->NgayNhan || !$yc->SLA_ApDung) {
                continue;
            }
            $daXuLy = Carbon::parse($yc->NgayNhan)
                ->diffInMinutes(now());

            $conLai = $yc->SLA_ApDung - $daXuLy;
            if ($conLai > 0 && $conLai <= 5) {
                $ketQua[] = [
                    'MaYC' => $yc->MaYC,
                    'ConLai' => $conLai
                ];
            }
        }
        return response()->json($ketQua);
    }
}
