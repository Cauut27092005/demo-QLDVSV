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
        Schema::table('yeucau_dichvu', function (Blueprint $table) {
            $table->foreign(['MaLoai'], 'fk_yeucau_loaidv')->references(['MaLoai'])->on('loai_dichvu')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yeucau_dichvu', function (Blueprint $table) {
            $table->dropForeign('fk_yeucau_loaidv');
        });
    }
};
