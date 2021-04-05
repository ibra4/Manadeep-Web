<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'price',
        'image',
        'location',
        'Age',
        'type',
        'user_id',
        'Description',
        'Bid_time',
        'approve',
        'seen',
    ];
    public function user()
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