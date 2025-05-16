<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users'; // tên bảng

    protected $primaryKey = 'id'; // khóa chính nếu không phải 'id'

    public $timestamps = false; // hoặc false nếu bảng không có created_at, updated_at

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'mssv',
        'email',
        'sdt',
        'hoten',
        'diachi',
        'avt_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
