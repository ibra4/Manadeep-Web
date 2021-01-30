<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderassociatl extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'location',
        'city',
        'associate_id',
        'user_id',
        'status',
        'order_type',
        'comments',
    ];
    public function associate()
    {
        return $this->belongsTo('App\\Models\\User', 'associate_id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }
}
