<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ptThanhToan extends Model
{
    use HasFactory;
    protected $table = 'phuongthucthanhtoan';
    protected $fillable = [
        'pttt_id', 'ten', 
    ];
    public $timestamps = false;
}