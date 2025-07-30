<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    protected $table = 'danhgia';

    protected $fillable = [
        'dg_id',
        'sp_id',
        'user_id',
        'binhluan',
        'anh_url',
        'created_at',
        'rating',
    ];

    public $timestamps = false;

}
