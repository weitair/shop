<?php

namespace Addon\Coupon\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $table   = 'coupon';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = [
        'coupon_type_text',
        'coupon_visible_text',
        'expire_type_text',
        'goods_limit_text',
        'status_text'
    ];

    protected $guarded = ['id'];

    protected $casts   = ['tag' => 'array'];

    // 状态(0：已结束、1：进行中)
    const STATUS_FINISHED = 0;
    const STATUS_START  = 1;

    // 发放类型(0：系统发放、1：主动领取)
    const COUPON_VISIBLE_OFF = 0;
    const COUPON_VISIBLE_ON  = 1;

    // 优惠卷类型(0：满减卷、1：折扣券)
    const COUPON_TYPE_MINUS    = 0;
    const COUPON_TYPE_DISCOUNT = 1;

    // 到期类型(0：领取后生效、1：固定时间)
    const EXPIRE_TYPE_DYNAMIC = 0;
    const EXPIRE_TYPE_FIXED   = 1;

    // 优惠卷发放类型
    const COUPON_PUSH_SELECT = 0; // 选择用户
    const COUPON_PUSH_TAG    = 1; // 指定标签用户
    const COUPON_PUSH_NEW    = 2; // 新用户
    const COUPON_PUSH_OLD    = 3; // 老用户

    // 适用商品
    const GOODS_LIMIT_ALL         = 0; // 全部商品可用
    const GOODS_LIMIT_AVAILABLE   = 1; // 指定商品可用
    const GOODS_LIMIT_UNAVAILABLE = 2; // 指定商品不可用

    // 是否同步打标签(0：否、1：是)
    const TAG_LIMIT_OFF = 0;
    const TAG_LIMIT_ON  = 1;

    // 不可见的优惠卷发放数为0(不限制)
    public function setTotalAttribute(int $value)
    {
        $this->attributes['total'] = $this->attributes['coupon_visible'] == self::COUPON_VISIBLE_OFF ? 0 : $value;
    }

    public function getAmountAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setAmountAttribute(float $value)
    {
        $this->attributes['amount'] = bcmul($value, 100);
    }

    public function getConditionAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setConditionAttribute(float $value)
    {
        $this->attributes['condition'] = bcmul($value, 100);
    }

    public function getDiscountLimitAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setDiscountLimitAttribute(float $value)
    {
        $this->attributes['discount_limit'] = bcmul($value, 100);
    }

    public function getBeginTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function setBeginTimeAttribute(string $value)
    {
        $this->attributes['begin_time'] = strtotime($value);
    }

    public function getEndTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function setEndTimeAttribute(string $value)
    {
        $this->attributes['end_time'] = strtotime($value);
    }

    public function getCouponTypeTextAttribute()
    {
        $status = [
            self::COUPON_TYPE_MINUS    => '满减卷',
            self::COUPON_TYPE_DISCOUNT => '折扣卷',
        ];
        return $status[$this->getAttribute('coupon_type')];
    }

    public function getCouponVisibleTextAttribute()
    {
        $status = [
            self::COUPON_VISIBLE_OFF => '系统发放',
            self::COUPON_VISIBLE_ON  => '主动领取',
        ];
        return $status[$this->getAttribute('coupon_visible')];
    }

    public function getExpireTypeTextAttribute()
    {
        $status = [
            self::EXPIRE_TYPE_DYNAMIC => '领取后生效',
            self::EXPIRE_TYPE_FIXED   => '固定时间',
        ];
        return $status[$this->getAttribute('expire_type')];
    }

    public function getGoodsLimitTextAttribute()
    {
        $status = [
            self::GOODS_LIMIT_ALL         => '全部商品可用',
            self::GOODS_LIMIT_AVAILABLE   => '指定商品可用',
            self::GOODS_LIMIT_UNAVAILABLE => '指定商品不可用',
        ];
        return $status[$this->getAttribute('goods_limit')];
    }

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_FINISHED => '已结束',
            self::STATUS_START    => '进行中',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function receive()
    {
        return $this->hasMany(CouponReceive::class);
    }

    public function goods()
    {
        return $this->belongsToMany(
            \App\Models\Goods::class,
            'coupon_goods',
            'coupon_id',
            'goods_id'
        );
    }
}
