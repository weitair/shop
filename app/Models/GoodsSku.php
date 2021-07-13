<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsSku extends Model
{
    use SoftDeletes;

    protected $table    = 'goods_sku';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['goods_id'];

    public function getSalesPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setSalesPriceAttribute(float $value)
    {
        $this->attributes['sales_price'] = bcmul($value, 100);
    }

    public function getLinePriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLinePriceAttribute(float $value)
    {
        $this->attributes['line_price'] = bcmul($value, 100);
    }

    public function getCostPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCostPriceAttribute(float $value)
    {
        $this->attributes['cost_price'] = bcmul($value, 100);
    }

    /**
     * 关联Sku Value
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function value()
    {
        return $this->hasMany(GoodsSkuValue::class);
    }

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class)->where('status', Goods::STATUS_ON);
    }
}
