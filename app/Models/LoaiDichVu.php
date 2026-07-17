<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiDichVu extends Model
{
    protected $table = 'loai_dichvu';
    protected $primaryKey = 'MaLoai';
    public $timestamps = false;
    protected $fillable = [
        'TenLoai'
    ];
}