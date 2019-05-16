<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $fillable = [
        'number' ,
        'status_id' ,
        'cities_id' ,
        'date_range'
    ];

    public function status()
    {
        return $this->belongsTo(OrderStatus::class , 'status_id');
    }

    public function steps()
    {
        return $this->belongsToMany('App\Step' , 'order_step' , 'orders_id' , 'steps_id')->withPivot('comment' , 'id');
    }

    public function orderStep()
    {
      return $this->hasOne('App\OrderStep' , 'orders_id')->latest();
    }

    public static function getListquery()
    {
        $query = Order::from('orders as o')
            ->select(
                'o.id as id' ,
                'o.number as order_number' ,
                's.id as step_id' ,
                's.step as step' ,
                'osp.created_at as date_order_step' ,
                'o.status_id as order_status_id' ,
                'ost.status as order_status' ,
                'o.created_at as date_order' ,
                'c.id as city_id' ,
                'c.city as city' ,
                DB::raw('timestampdiff(DAY , o.created_at , curdate()) as days') ,
                DB::raw('timestampdiff(DAY , o.created_at , osp.created_at) as final_day')
            )
            ->leftJoin('order_step as osp' , 'osp.orders_id' , 'o.id')
            ->leftJoin('steps as s' , 's.id' , 'osp.steps_id')
            ->leftJoin('order_status as ost' , 'ost.id' , 'o.status_id')
            ->leftJoin('cities as c' , 'c.id' , 'o.cities_id')
            ->where('osp.actual' , 1)
        ;

        return $query;
    }

    /*public function posts()
    {
        return $this->hasManyThrough(
            'App\Post', 'App\User',
            'country_id', 'user_id', 'id'
        );
    }*/
}
