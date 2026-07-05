<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('nhanvien_xuly', function (Blueprint $table) {
        $table->dropColumn('TrangThaiOnline');
    });
}

public function down()
{
    Schema::table('nhanvien_xuly', function (Blueprint $table) {
        $table->boolean('TrangThaiOnline')->default(0);
    });
}
};
