<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class GoodsImages extends Model
{
    use SoftDeletes;

    protected $table    = 'goods_images';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['name', 'goods_id'];
}
