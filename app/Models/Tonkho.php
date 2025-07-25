<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tonkho extends Model
{
    protected $table = 'kho'; // Tên bảng
    protected $primaryKey = 'id'; // Khóa chính

    public $timestamps = false;

    protected $fillable = [
        'kho_id',
        'sp_id',
        'size_id',
        'tonkho',
    ];

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'sp_id', 'sp_id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'size_id');
    }
}