<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'driver_id',
        'Order_id',
        'Order_Cost',
    ];
    public function associate()
    { 
        return $this->belongsTo('App\\Models\\User', 'driver_id');
    }
}
