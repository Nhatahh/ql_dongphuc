<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $table = '24_danhmuc_size';
    protected $fillable = [
        'id', 'size', 
    ];
    public $timestamps = false;
}