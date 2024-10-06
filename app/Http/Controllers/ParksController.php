<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParksController extends Controller
{
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id'); // Указываем нужные столбцы;
    }

    public function contractors()
    {
        return $this->hasMany(Park_contractor::class, 'park_id');
    }

    public function trees()
    {
        return $this->hasMany(Tree::class, 'park_id');
    }
}
