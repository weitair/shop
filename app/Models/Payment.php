<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $table      = 'payment';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['payment_channel_text', 'status_text'];

    protected $attributes = ['payment_channel' => 0, 'status' => 0];

    protected $guarded    = ['member_id'];

    // 支付状态(0：未支付、1：支付中、2：已支付)
    const STATUS_UNPAID = 0;
    const STATUS_PAYING = 1;
    const STATUS_PAID   = 2;

    // 支付渠道(wechat：微信支付)
    const PAYMENT_CHANNEL_WECHAT = 'wechat';

    public function getPaymentPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setPaymentPriceAttribute(float $value)
    {
        $this->attributes['payment_price'] = bcmul($value, 100);
    }

    public function getPaymentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_UNPAID => '未支付',
            self::STATUS_PAYING => '支付中',
            self::STATUS_PAID   => '已支付',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getPaymentChannelTextAttribute()
    {
        $status = [
            self::PAYMENT_CHANNEL_WECHAT => '微信支付',
        ];
        return $status[$this->getAttribute('payment_channel')];
    }

    /**
     * 反向关联到用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 反向关联到订单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * 反向关联到支付渠道表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(PaymentChannel::class, 'payment_channel_id');
    }
}
