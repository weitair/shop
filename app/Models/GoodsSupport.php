<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsSupport extends Model
{
    use SoftDeletes;

    protected $table    = 'goods_support';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['support_name', 'content', 'sort', 'status'];

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
            'goods_support_pivot',
            'support_id',
            'goods_id'
        );
    }
}
