<?php

namespace App\Exports;

use App\Models\NhanVienXuLy;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopNhanVienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return NhanVienXuLy::leftJoin(
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
                ) as Tong
            ")
            ->groupBy(
                "nhanvien_xuly.MaNV",
                "nhanvien_xuly.HoTen"
            )
            ->orderByDesc("Tong")
            ->limit(5)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Mã nhân viên',
            'Họ tên',
            'Số yêu cầu hoàn thành'
        ];
    }
}