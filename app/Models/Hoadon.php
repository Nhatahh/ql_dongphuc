<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoadon extends Model
{
    use HasFactory;

    protected $table = 'hoadon';
    protected $primaryKey = 'hd_id';
    protected $fillable = [
        'hd_id', 'user_id', 'tongtien', 'tt_id', 'pttt_id', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function trangthai()
    {
        return $this->belongsTo(Trangthai::class, 'tt_id', 'tt_id');
    }

    public function chitietHoadon()
    {
        return $this->hasMany(Chitiethoadon::class, 'hd_id', 'hd_id');
    }
}
