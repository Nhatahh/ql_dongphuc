<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\TrangThai;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin'; // tên bảng

    protected $primaryKey = 'id'; // khóa chính nếu không phải 'id'

    public $timestamps = true; // hoặc false nếu bảng không có created_at, updated_at

    protected $fillable = [
        'admin_id',
        'username',
        'password',
        'created_at',
        'trangthai',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function trangThai()
    {
        return $this->hasOne(TrangThai::class, 'tt_id', 'trangthai');
    }
}
