<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cite extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name_en',
        'name_ar',
    ];
}
