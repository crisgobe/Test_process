<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStep extends Model
{
    protected $table = 'order_step';

    protected $fillable = [
        'orders_id' ,
        'steps_id' ,
        'comment' ,
        'users_id' ,
        'status_id' ,
        'actual' ,
        'next'
    ];

    public function step()
    {
        return $this->belongsTo(Step::class , 'steps_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class , 'orders_id');
    }

    public function status()
    {
        return $this->belongsTo(StepStatus::class , 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'users_id');
    }
}
