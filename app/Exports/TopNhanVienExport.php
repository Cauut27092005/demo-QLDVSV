<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopNhanVienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Users::leftJoin(
                "yeucau_dichvu",
                "users.MaNV",
                "=",
                "yeucau_dichvu.MaNV"
            )
            ->selectRaw("
                users.MaNV,
                users.HoTen,
                COUNT(
                    CASE
                    WHEN TrangThai='HoanThanh'
                    THEN 1
                    END
                ) as Tong
            ")
            ->groupBy(
                "users.MaNV",
                "users.HoTen"
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