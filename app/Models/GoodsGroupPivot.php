<?php

namespace App\Models;

class GoodsGroupPivot extends Model
{
    protected $table    = 'goods_group_pivot';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'goods_id',
        'group_id',
    ];
}
