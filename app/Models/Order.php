<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table   = 'order';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    protected $appends = [
        'order_status_text',
        'payment_status_text',
        'shipment_status_text',
        'receive_status_text',
        'comment_status_text',
        'invoice_status_text',
        'logistics_method_text',
        'payment_channel_text',
        'channel_text',
    ];

    protected $attributes = [
        'order_status'    => 0,
        'order_progress'  => 0,
        'payment_status'  => 0,
        'shipment_status' => 0,
        'receive_status'  => 0,
        'comment_status'  => 0,
        'invoice_status'  => 0,
        'logistics_price' => 0,
        'goods_price'     => 0,
        'coupon_price'    => 0,
        'discount_price'  => 0,
        'change_price'    => 0,
        'payment_price'   => 0,
        'channel'         => 0,
        'payment_channel' => 'wechat',
    ];

    // 订单状态(0：待支付、1:待发货、2：待收货、3：已完成、4：已关闭)
    const ORDER_STATUS_CREATED  = 0;  // 订单创建/待支付
    const ORDER_STATUS_PAID     = 1;  // 已支付/待发货
    const ORDER_STATUS_SHIPPED  = 2;  // 已发货/待收货
    const ORDER_STATUS_FINISHED = 3;  // 已收货/已完成
    const ORDER_STATUS_CLOSED   = 4;  // 已关闭/已取消

    // 订单进度(0：未开始、1：进行中、2：已完成)
    const ORDER_PROGRESS          = 0;
    const ORDER_PROGRESS_START    = 1;
    const ORDER_PROGRESS_FINISHED = 2;

    // 物流方式(0：快递、1：同城、2：自提)
    const LOGISTICS_METHOD_EXPRESS = 0;
    const LOGISTICS_METHOD_LOCAL   = 1;
    const LOGISTICS_METHOD_FETCH   = 2;

    // 支付状态(0：未支付、1：已支付)
    const PAYMENT_STATUS_UN       = 0;
    const PAYMENT_STATUS_FINISHED = 1;

    // 发货状态(0：未发货、1:部分发货、2：已发货)
    const SHIPMENT_STATUS_UN       = 0;
    const SHIPMENT_STATUS_PARTIAL  = 1;
    const SHIPMENT_STATUS_FINISHED = 2;

    // 签收状态(0：未签收、2：已签收)
    const RECEIVE_STATUS_UN       = 0;
    const RECEIVE_STATUS_FINISHED = 1;

    // 评论(0：未评论、1：已评论)
    const COMMENT_STATUS_UN       = 0;
    const COMMENT_STATUS_FINISHED = 1;

    // 发票(0：不开票、1：开票)
    const INVOICE_STATUS_NOT  = 0;
    const INVOICE_STATUS_NEED = 1;

    // 用户删除订单(0：否、1：是)
    const DELETE_STATUS_OFF = 0;
    const DELETE_STATUS_NO  = 1;

    // 支付渠道(wechat：微信支付)
    const PAYMENT_CHANNEL_WECHAT = 'wechat';

    public function getGoodsPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setGoodsPriceAttribute(float $value)
    {
        $this->attributes['goods_price'] = bcmul($value, 100);
    }

    public function getCouponPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCouponPriceAttribute(float $value)
    {
        $this->attributes['coupon_price'] = bcmul($value, 100);
    }

    public function getDiscountPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setDiscountPriceAttribute(float $value)
    {
        $this->attributes['discount_price'] = bcmul($value, 100);
    }

    public function getChangePriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setChangePriceAttribute(float $value)
    {
        $this->attributes['change_price'] = bcmul($value, 100);
    }

    public function getPaymentPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setPaymentPriceAttribute(float $value)
    {
        $this->attributes['payment_price'] = bcmul($value, 100);
    }

    public function getLogisticsPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLogisticsPriceAttribute(float $value)
    {
        $this->attributes['logistics_price'] = bcmul($value, 100);
    }

    public function getOrderTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getPaymentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getShipmentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getFinishTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getCloseTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getOrderStatusTextAttribute()
    {
        $status = [
            self::ORDER_STATUS_CREATED  => '待付款',
            self::ORDER_STATUS_PAID     => '待发货',
            self::ORDER_STATUS_SHIPPED  => '待收货',
            self::ORDER_STATUS_FINISHED => '交易成功',
            self::ORDER_STATUS_CLOSED   => '交易关闭',
        ];
        return $status[$this->getAttribute('order_status')];
    }

    public function getPaymentStatusTextAttribute()
    {
        $status = [
            self::PAYMENT_STATUS_UN       => '待支付',
            self::PAYMENT_STATUS_FINISHED => '已支付',
        ];
        return $status[$this->getAttribute('payment_status')];
    }

    public function getShipmentStatusTextAttribute()
    {
        $status = [
            self::SHIPMENT_STATUS_UN       => '待发货',
            self::SHIPMENT_STATUS_PARTIAL  => '部分发货',
            self::SHIPMENT_STATUS_FINISHED => '已发货',
        ];
        return $status[$this->getAttribute('shipment_status')];
    }

    public function getReceiveStatusTextAttribute()
    {
        $status = [
            self::RECEIVE_STATUS_UN       => '待签收',
            self::RECEIVE_STATUS_FINISHED => '已签收',
        ];
        return $status[$this->getAttribute('receive_status')];
    }

    public function getCommentStatusTextAttribute()
    {
        $status = [
            self::COMMENT_STATUS_UN       => '待评价',
            self::COMMENT_STATUS_FINISHED => '已评价',
        ];
        return $status[$this->getAttribute('comment_status')];
    }

    public function getInvoiceStatusTextAttribute()
    {
        $status = [
            self::INVOICE_STATUS_NOT  => '不开票',
            self::INVOICE_STATUS_NEED => '开票',
        ];
        return $status[$this->getAttribute('invoice_status')];
    }

    public function getChannelTextAttribute()
    {
        $status = [
            self::CHANNEL_WECHAT     => '公众号',
            self::CHANNEL_WECHAT_APP => '小程序',
            self::CHANNEL_H5         => 'H5',
        ];
        return $status[$this->getAttribute('channel')];
    }

    public function getPaymentChannelTextAttribute()
    {
        $status = [
            self::PAYMENT_CHANNEL_WECHAT => '微信支付',
        ];
        return $status[$this->getAttribute('payment_channel')];
    }

    public function getLogisticsMethodTextAttribute()
    {
        $status = [
            self::LOGISTICS_METHOD_EXPRESS => '快递发货',
            self::LOGISTICS_METHOD_LOCAL   => '同城配送',
            self::LOGISTICS_METHOD_FETCH   => '门店自提',
        ];
        return $status[$this->getAttribute('logistics_method')];
    }

    /**
     * 关联订单商品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany(OrderGoods::class);
    }

    /**
     * 关联订单物流
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logistics()
    {
        return $this->hasOne(OrderLogistics::class);
    }

    /**
     * 关联订单包裹表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function package()
    {
        return $this->hasMany(OrderPackage::class);
    }

    /**
     * 关联上门自提表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fetch()
    {
        return $this->hasOne(OrderFetch::class);
    }

    /**
     * 关联评论表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class);
    }

    /**
     * 关联订单发票
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(OrderInvoice::class);
    }

    /**
     * 反向关联到用户表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 关联到售后表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function service()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * 关联支付记录表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * 关联核销记录表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verify()
    {
        return $this->hasMany(OrderVerify::class);
    }
}
