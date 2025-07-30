<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cthd extends Model
{
    use HasFactory;
    protected $table = 'chitiethoadon';
    // protected $primaryKey = 'cthd_id';
    public $timestamps = false;

    protected $fillable = ['cthd_id', 'hd_id', 'sp_id', 'size_id', 'soluong', 'gia'];
}

