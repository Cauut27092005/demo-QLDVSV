<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'SLA_ApDung',
        'DatSLA',
        'TrangThai',
        'NgayHoanThanh',
    ];
    protected $casts = [
        'NgayGui' => 'datetime',
        'NgayNhan' => 'datetime',
        'NgayHoanThanh' => 'datetime',
        'SLA_ApDung' => 'integer',
        'DatSLA' => 'boolean',
    ];
    public function loaiDichVu(): BelongsTo
    {
        return $this->belongsTo(
            LoaiDichVu::class,
            'MaLoai',
            'MaLoai'
        );
    }
    public function nhanVien(): BelongsTo
    {
        return $this->belongsTo(
            Users::class,
            'MaNV',
            'MaNV'
        );
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}