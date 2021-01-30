<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAssociate extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'location',
        'locationName',
        'associate_id',
        'user_id',
        'status',
        'package_name',
        'SubPackage_name',
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
