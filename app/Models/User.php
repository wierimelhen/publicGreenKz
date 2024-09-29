<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;

    protected $table = 'users';
    // const CREATED_AT = 'created_dt';
    // const UPDATED_AT = 'updated_dt';
    protected $fillable = ['second_name', 'name', 'surname', 'subdivision', 'rank', 'phone', 'post'];

    protected $hidden = [
        'password',
    ];

    // protected $dates = ['created_dt', 'updated_dt'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFioAttribute()
    {
        return $this->second_name . ' ' . $this->name;
    }

    public function getAuthEmail()
    {
        return $this->second_name;
    }
}
