<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrangThai extends Model
{
    protected $table = 'trangthai';

    // Khóa chính là 'id'
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = ['tt_id', 'ten'];
}