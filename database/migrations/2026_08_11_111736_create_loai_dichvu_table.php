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
        Schema::create('loai_dichvu', function (Blueprint $table) {
            $table->integer('MaLoai', true);
            $table->string('TenLoai', 100)->unique('tenloai');
            $table->string('MaNV', 20)->nullable();
            $table->integer('SLA_Phut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loai_dichvu');
    }
};
