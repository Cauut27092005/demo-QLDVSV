<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE yeucau_dichvu
            DROP CONSTRAINT IF EXISTS yeucau_dichvu_trangthai_check
        ");

        DB::statement("
            ALTER TABLE yeucau_dichvu
            ADD CONSTRAINT yeucau_dichvu_trangthai_check
            CHECK (TrangThai IN (
                'ChoXuLy',
                'DangXuLy',
                'HoanThanh',
                'Huy'
            ))
        ");

        DB::statement("
            ALTER TABLE yeucau_dichvu
            ALTER COLUMN TrangThai SET DEFAULT 'ChoXuLy'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE yeucau_dichvu
            DROP CONSTRAINT IF EXISTS yeucau_dichvu_trangthai_check
        ");

        DB::statement("
            ALTER TABLE yeucau_dichvu
            ALTER COLUMN TrangThai SET DEFAULT 'ChoXuLy'
        ");
    }
};