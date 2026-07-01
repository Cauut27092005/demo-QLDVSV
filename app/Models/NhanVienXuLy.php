<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVienXuLy extends Model
{
    protected $table = 'nhanvien_xuly';
    protected $primaryKey = 'MaNV';
    public $timestamps = false;
    protected $fillable = [
        'MaNV',
        'HoTen',
        'BoPhan',
        'TrangThaiOnline'
    ];
    public $incrementing = false;
    protected $keyType = 'string';
}
