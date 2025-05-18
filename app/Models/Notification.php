<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'thongbao';
    protected $fillable = [
        'noti_id', 'user_id', 'title', 'message', 'is_read'
    ];
    public $timestamps = true;
}