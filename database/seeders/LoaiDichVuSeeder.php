<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiDichVuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('loai_dichvu')->insertOrIgnore([
            ['TenLoai' => 'Hành chính'],
            ['TenLoai' => 'Hỗ trợ học vụ'],
            ['TenLoai' => 'Tài chính'],
            ['TenLoai' => 'Khác'],
            ['TenLoai' => 'QHDN'],
            ['TenLoai' => 'Nhà trọ, phòng trọ'],
            ['TenLoai' => 'Hỗ trợ CNTT'],
        ]);
    }
}
