<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceGoods extends Model
{
    use SoftDeletes;

    protected $table    = 'service_goods';

    protected $hidden   = [];

    protected $guarded = ['goods_id'];

    public function getSalesPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setSalesPriceAttribute(float $value)
    {
        $this->attributes['sales_price'] = bcmul($value, 100);
    }

    public function getCostPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCostPriceAttribute(float $value)
    {
        $this->attributes['cost_price'] = bcmul($value, 100);
    }

    public function getTotalAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setTotalAttribute(float $value)
    {
        $this->attributes['total'] = bcmul($value, 100);
    }
    public function getRefundPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setRefundPriceAttribute(float $value)
    {
        $this->attributes['refund_price'] = bcmul($value, 100);
    }

    public function getDiscountPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setDiscountPriceAttribute(float $value)
    {
        $this->attributes['discount_price'] = bcmul($value, 100);
    }
}
