<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $table = 'sinhvien';

    protected $primaryKey = 'MaSV';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'MaSV',
        'HoTen',
        'Email',
        'SDT'
    ];
}
