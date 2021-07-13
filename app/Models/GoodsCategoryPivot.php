<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCategoryPivot extends Model
{
    use SoftDeletes;

    protected $table    = 'goods_category_pivot';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['category_id', 'goods_id', 'level'];
}
