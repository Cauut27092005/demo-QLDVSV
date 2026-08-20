<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class YeuCauDichVu extends Model
{
    protected $table = 'yeucau_dichvu';
    protected $primaryKey = 'MaYC';
    public $timestamps = false;

    protected $fillable = [
        'MaSV',
        'MaNV',
        'MaLoai',
        'NgayGui',
        'NgayNhan',
        'NgayHoanThanh',
        'TrangThai',
        'SLA_ApDung',
        'DatSLA'
    ];
    protected $casts = [
        'NgayGui' => 'datetime',
        'NgayNhan' => 'datetime',
        'NgayHoanThanh' => 'datetime',
        'DatSLA' => 'boolean',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
