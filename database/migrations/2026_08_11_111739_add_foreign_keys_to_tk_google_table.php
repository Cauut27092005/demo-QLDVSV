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
        Schema::table('tk_google', function (Blueprint $table) {
            $table->foreign(['MaNV'], 'fk_tk_google_users')->references(['MaNV'])->on('users')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tk_google', function (Blueprint $table) {
            $table->dropForeign('fk_tk_google_users');
        });
    }
};
