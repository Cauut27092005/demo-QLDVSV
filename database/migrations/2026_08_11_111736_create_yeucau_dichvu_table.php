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
        Schema::create('yeucau_dichvu', function (Blueprint $table) {
            $table->integer('MaYC', true);
            $table->string('MaSV', 20);
            $table->string('MaNV', 20)->nullable();
            $table->dateTime('NgayGui')->nullable()->useCurrent();
            $table->dateTime('NgayNhan')->nullable();
            $table->integer('SLA_ApDung')->nullable();
            $table->boolean('DatSLA')->nullable();
            $table->enum('TrangThai', ['ChoXuLy', 'DangXuLy', 'HoanThanh'])->nullable()->default('ChoXuLy');
            $table->dateTime('NgayHoanThanh')->nullable();
            $table->integer('MaLoai')->nullable()->index('fk_yeucau_loaidv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yeucau_dichvu');
    }
};
