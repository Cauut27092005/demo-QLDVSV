<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
    protected $table = 'taikhoan';
    protected $primaryKey = 'MaTK';
    public $timestamps = false;
    protected $fillable = [
        'Username',
        'Password',
        'VaiTro',
        'MaNV',
        'DaDoiMatKhau'
    ];
}