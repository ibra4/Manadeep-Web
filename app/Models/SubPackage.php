<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPackage extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'name',
        'name_ar',
        'name_en',
        'package_id'
    ];
    
    public function packags()
    {
        return $this->belongsToMany('App\Models\packags');
    }
    
}
