<?php

namespace App\Exports;

use App\Models\YeuCauDichVu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class YeuCauExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return YeuCauDichVu::leftJoin(
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
                'yeucau_dichvu.MaYC',
                'yeucau_dichvu.MaSV',
                'loai_dichvu.TenLoai as LoaiDichVu',
                'users.HoTen as TenNhanVien',
                'yeucau_dichvu.TrangThai',
                'yeucau_dichvu.NgayGui',
                'yeucau_dichvu.NgayHoanThanh'
            )
            ->orderByDesc('yeucau_dichvu.MaYC')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Mã yêu cầu',
            'Mã sinh viên',
            'Loại dịch vụ',
            'Nhân viên xử lý',
            'Trạng thái',
            'Ngày gửi',
            'Ngày hoàn thành'
        ];
    }
}