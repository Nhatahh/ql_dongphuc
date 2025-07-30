<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_subject',
        'name_subject',
        'note_subject',
        'active_subject',
        'num_subject',
    ];
}
