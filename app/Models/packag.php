<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packag extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'package_name_ar',
        'package_name_en'
    ];
}
