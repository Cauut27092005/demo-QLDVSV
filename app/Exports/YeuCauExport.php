<?php

namespace App\Exports;

use App\Models\YeuCauDichVu;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class YeuCauExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $maNV = session('MaNV');
        return YeuCauDichVu::where('MaNV', $maNV)
            ->select(
                'MaYC',
                'MaSV',
                'LoaiDichVu',
                'NgayGui',
                'TrangThai',
                'NgayHoanThanh'
            )
            ->orderByDesc('MaYC')
            ->get();
    }
    public function headings(): array
    {
        return [
            'Mã YC',
            'Mã SV',
            'Loại dịch vụ',
            'Ngày gửi',
            'Trạng thái',
            'Ngày hoàn thành'
        ];
    }
}