<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commission extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'commission_name',
        'commission_value',
    ];
}
