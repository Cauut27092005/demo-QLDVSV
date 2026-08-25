<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TkGoogle extends Model
{
    protected $table = 'tk_google';
    protected $primaryKey = 'MaND';
    public $timestamps = false;
    protected $fillable = [
        'MaNV',
        'GoogleID',
        'Email',
        'HoTen',
        'VaiTro',
        'TrangThai',
        'LanDangNhapCuoi',
        'CreatedAt',
    ];
    protected $casts = [
        'LanDangNhapCuoi' => 'datetime',
        'CreatedAt' => 'datetime',
    ];
    public function nhanVien(): BelongsTo
    {
        return $this->belongsTo(
            Users::class,
            'MaNV',
            'MaNV'
        );
    }
}