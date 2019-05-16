<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name' ,
        'email' ,
        'user_types_id' ,
        'status_id' ,
        'password'
    ];

    protected $hidden = [
        'password' ,
        'remember_token'
    ];

    public function status()
    {
        return $this->belongsTo(UserStatus::class , 'status_id');
    }

    public function userTypes()
    {
        return $this->belongsTo(UserType::class , 'user_types_id');
    }
}
