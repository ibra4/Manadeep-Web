<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    public function city1() {
        return $this->belongsTo('App\Models\City', 'city_id_1')->get()->first();
    }

    public function city2() {
        return $this->belongsTo('App\Models\City', 'city_id_2')->get()->first();
    }
}
