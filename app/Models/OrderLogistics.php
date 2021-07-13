<?php

namespace App\Models;

class OrderLogistics extends Model
{
    protected $table   = 'order_logistics';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['order_id'];
}
