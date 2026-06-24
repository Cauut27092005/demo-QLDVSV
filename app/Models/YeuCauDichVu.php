<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class YeuCauDichVu extends Model
{
    protected $table = 'yeucau_dichvu';
    protected $primaryKey = 'MaYC';
    public $timestamps = false;
    protected $fillable = [
        'MaSV',
        'MaNV',
        'LoaiDichVu',
        'NgayGui',
        'TrangThai',
        'NgayHoanThanh'
    ];
}