<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'Order_id',
        'message',
        'seen',
    ];
    public function associate()
    {
        return $this->belongsTo('App\\Models\\User', 'driver_id');
    }
}
