<?php

namespace App\Exports;

use App\Models\YeuCauDichVu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class YeuCauExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return YeuCauDichVu::where(
                'MaNV',
                session('Username')
            )
            ->where(
                'TrangThai',
                'HoanThanh'
            )
            ->select(
                'MaYC',
                'MaSV',
                'LoaiDichVu',
                'NgayGui',
                'NgayHoanThanh'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Mã yêu cầu',
            'Mã sinh viên',
            'Loại dịch vụ',
            'Ngày gửi',
            'Ngày hoàn thành'
        ];
    }
}