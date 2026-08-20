<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaiKhoanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('taikhoan')->insertOrIgnore([
            ['Username' => 'admin', 'Password' => bcrypt('1'),     'VaiTro' => 'Admin'],
            ['Username' => 'huong', 'Password' => bcrypt('123456'), 'VaiTro' => 'Admin'],
            ['Username' => 'tp01',  'Password' => bcrypt('123'),    'VaiTro' => 'TruongPhong'],
        ]);
    }
}
