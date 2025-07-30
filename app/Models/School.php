<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_school',
        'name_school',
        'address_school',
        'rector_school',
        'phone_rector_school',
        'id_province',
        'priority_area_school',
        'nation_school',
        'active_school',
        'gps_school',
        'note_school'

    ];
}
