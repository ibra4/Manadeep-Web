<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'estimate_price',
        'last_price',
        'image',
        'location',
        'sex',
        'Age',
        'type',
        'user_id',
        'Description',
        'Bid_time',
        'approve',
    ];
    public function users()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }
    public function types()
    {
        return $this->belongsTo('App\\Models\\type', 'type');
    }
    public function citys()
    {
        return $this->belongsTo('App\\Models\\cite', 'location');
    }
}
