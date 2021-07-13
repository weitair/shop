<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCategory extends Model
{
    use SoftDeletes;

    protected $table    = 'goods_category';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['timestamp'];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    /**
     * 关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function goods()
    {
        return $this->belongsToMany(
            Goods::class,
            'goods_category_pivot',
            'category_id',
            'goods_id'
        )
            ->withPivot('goods_id', 'category_id', 'level')
            ->orderBy('level', 'asc');
    }
}
