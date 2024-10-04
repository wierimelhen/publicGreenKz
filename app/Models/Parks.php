<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parks extends Model
{
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function contractors()
    {
        return $this->hasMany(Park_contractors::class, 'park_id');
    }

    public function trees()
    {
        return $this->hasMany(Tree::class, 'park_id');
    }
}
