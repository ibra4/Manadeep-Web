<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'price',
        'image',
        'location',
        'status',
        'user_id',
        'Description',
        'approve'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }
    public function citys()
    {
        return $this->belongsTo('App\\Models\\cite', 'location');
    }
}
