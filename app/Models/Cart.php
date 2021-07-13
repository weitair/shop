<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $table   = 'cart';

    protected $hidden  = ['member_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    public function getSalesPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setSalesPriceAttribute(float $value)
    {
        $this->attributes['sales_price'] = bcmul($value, 100);
    }

    public function getAddTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    /**
     * 关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class)->where(['status' => Goods::STATUS_ON]);
    }

    /**
     * 关联到Sku
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku()
    {
        return $this->belongsTo(GoodsSku::class, 'goods_sku_id');
    }
}
