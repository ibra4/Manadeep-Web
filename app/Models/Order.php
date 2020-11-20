<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function driver()
    {
        return $this->belongsTo('App\\Models\\User', 'driver_id');
    }

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }

    
}
