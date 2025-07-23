<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanpham extends Model
{
    use HasFactory;
    protected $table = 'sanpham';
    protected $fillable = [
        'sp_id', 'tensp', 'mota', 'gia', 'image_url', 'dm_id', 'nsx_id',
    ];
    public $timestamps = true;
    public function danhmuc()
    {
        return $this->belongsTo(Danhmuc::class, 'dm_id', 'dm_id');
    }
    public function nhasanxuat()
    {
        return $this->belongsTo(nhaSX::class, 'nsx_id', 'nsx_id');
    }
    public function tonkho()
    {
        return $this->hasMany(Tonkho::class, 'sp_id', 'sp_id');
    }
    public function chitiethoadon()
    {
        return $this->hasMany(Chitiethoadon::class, 'sp_id', 'sp_id');
    }
}