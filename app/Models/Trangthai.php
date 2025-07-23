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

    public function accAdmin()
    {
        return $this->hasOne(Admin::class, 'tt_id', 'trangthai');
    }

    public function accUser()
    {
        return $this->hasOne(User::class, 'tt_id', 'trangthai');
    }
    public function hoaDon()
    {
        return $this->hasOne(Hoadon::class, 'tt_id', 'trangthai');
    }
}