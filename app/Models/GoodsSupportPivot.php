<?php

namespace App\Models;

class GoodsSupportPivot extends Model
{
    protected $table    = 'goods_support_pivot';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'goods_id',
        'support_id',
    ];
}
