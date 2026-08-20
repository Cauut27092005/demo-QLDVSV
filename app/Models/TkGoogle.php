<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}