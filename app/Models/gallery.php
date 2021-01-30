<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'filepath',
    ];
    public function associate()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }
}
