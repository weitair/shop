<?php

namespace App\Models;

class OrderGoods extends Model
{
    protected $table     = 'order_goods';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['shipment_status_text'];

    protected $attributes = ['shipment_status' => 0];

    protected $guarded    = ['order_id'];

    // 发货状态(0:未发货、1:已发货)
    const SHIPMENT_STATUS_UN       = 0;
    const SHIPMENT_STATUS_FINISHED = 1;

    public function getShipmentStatusTextAttribute()
    {
        if (array_key_exists('shipment_status', $this->attributes)) {
            $status = [
                self::SHIPMENT_STATUS_UN       => '待发货',
                self::SHIPMENT_STATUS_FINISHED => '已发货',
            ];
            return $status[$this->getAttribute('shipment_status')];
        }
    }

    public function getShipmentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

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

    public function getGoodsPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setGoodsPriceAttribute(float $value)
    {
        $this->attributes['goods_price'] = bcmul($value, 100);
    }

    public function getPaymentPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setPaymentPriceAttribute(float $value)
    {
        $this->attributes['payment_price'] = bcmul($value, 100);
    }

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    /**
     * 反向关联到Sku
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku()
    {
        return $this->belongsTo(GoodsSku::class, 'goods_sku_id');
    }

    /**
     * 反向关联到订单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
