<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chitiethoadon extends Model
{
    use HasFactory;

    protected $table = 'chitiethoadon';
    protected $primaryKey = 'cthd_id';
    protected $fillable = [
        'cthd_id', 'hd_id', 'sp_id', 'size_id', 'soluong', 'gia'
    ];

    public function hoadon()
    {
        return $this->belongsTo(Hoadon::class, 'hd_id', 'hd_id');
    }

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'sp_id', 'sp_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'size_id');
    }
}
