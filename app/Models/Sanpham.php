<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    use HasFactory;
    protected $table = 'sanpham';
    protected $fillable = [
        'sp_id', 'kho_id', 'tensp', 'mota', 'gia', 'image_url', 'dm_id', 'nsx_id',
    ];
    public $timestamps = true;
}