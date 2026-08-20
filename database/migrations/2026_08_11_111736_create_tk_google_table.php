<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tk_google', function (Blueprint $table) {
            $table->integer('MaND', true);
            $table->string('MaNV', 20)->nullable()->index('fk_tk_google_users');
            $table->string('GoogleID', 100)->nullable()->unique('googleid');
            $table->string('Email')->nullable()->unique('email');
            $table->enum('VaiTro', ['Admin', 'TruongPhong', 'NhanVien'])->nullable();
            $table->enum('TrangThai', ['ChoDuyet', 'HoatDong', 'TuChoi'])->nullable()->default('ChoDuyet');
            $table->dateTime('LanDangNhapCuoi')->nullable();
            $table->timestamp('CreatedAt')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tk_google');
    }
};
