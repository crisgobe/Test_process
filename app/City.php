<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city' ,
        'departments_id'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class , 'departments_id');
    }
}
