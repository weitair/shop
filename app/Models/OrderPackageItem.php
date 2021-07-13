<?php

namespace App\Models;

class OrderPackageItem extends Model
{
    protected $table   = 'order_package_item';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['package_id'];

    /**
     * 反向关联到订单商品表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(OrderGoods::class, 'goods_id');
    }
}
