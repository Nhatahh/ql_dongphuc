<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nhaSX extends Model
{
    use HasFactory;
    protected $table = 'nhasanxuat';
    protected $fillable = [
        'nsx_id', 'ten', 
    ];
    public $timestamps = false;
}