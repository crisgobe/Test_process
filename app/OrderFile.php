<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderFile extends Model
{
    protected $table = 'order_file';

    protected $fillable = [
    	'orders_id' ,
    	'files_id'
    ];
}
