<?php

namespace App\Exports;

use App\Models\YeuCauDichVu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NhanVienExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return YeuCauDichVu::join(
                'loai_dichvu',
                'yeucau_dichvu.MaLoai',
                '=',
                'loai_dichvu.MaLoai'
            )
            ->where(
                'yeucau_dichvu.MaNV',
                session('Username')
            )
            ->where(
                'yeucau_dichvu.TrangThai',
                'HoanThanh'
            )
            ->select(
                'yeucau_dichvu.MaYC',
                'yeucau_dichvu.MaSV',
                'loai_dichvu.TenLoai as LoaiDichVu',
                'yeucau_dichvu.NgayGui',
                'yeucau_dichvu.NgayHoanThanh'
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