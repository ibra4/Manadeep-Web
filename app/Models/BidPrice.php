<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidPrice extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'bid_id',
        'price',
    ];
    public function bid()
    {
        return $this->belongsTo('App\\Models\\Bid', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }
}
