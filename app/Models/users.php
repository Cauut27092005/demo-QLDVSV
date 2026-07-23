<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'MaNV';
    public $timestamps = false;
    protected $fillable = [
        'MaNV',
        'HoTen',
        'Quay'
    ];
    public $incrementing = false;
    protected $keyType = 'string';
}
