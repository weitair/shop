<?php

namespace Addon\Coupon\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Member;
use App\Models\Model;
use Carbon\Carbon;

class CouponReceive extends Model
{
    use SoftDeletes;

    protected $table   = 'coupon_receive';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = [
        'coupon_type_text',
        'source_text',
        'status_text',
        'goods_limit_text',
    ];

    protected $guarded = ['member_id'];

    // 优惠卷类型(0：满减卷、1：折扣券)
    const COUPON_TYPE_MINUS    = 0;
    const COUPON_TYPE_DISCOUNT = 1;

    // 状态(0：未使用、1：已使用)
    const STATUS_UNUSED = 0;
    const STATUS_USED   = 1;

    // 优惠卷来源(0：主动领取、1：系统发放)
    const SOURCE_RECEIVE = 0;
    const SOURCE_PUSH    = 1;

    // 适用商品
    const GOODS_LIMIT_ALL         = 0; // 全部商品可用
    const GOODS_LIMIT_AVAILABLE   = 1; // 指定商品可用
    const GOODS_LIMIT_UNAVAILABLE = 2; // 指定商品不可用

    public function getCouponTypeTextAttribute()
    {
        $status = [
            self::COUPON_TYPE_MINUS    => '满减卷',
            self::COUPON_TYPE_DISCOUNT => '折扣卷',
        ];
        return $status[$this->getAttribute('coupon_type')];
    }

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_UNUSED => '未使用',
            self::STATUS_USED   => '已使用',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getSourceTextAttribute()
    {
        $status = [
            self::SOURCE_RECEIVE => '主动领取',
            self::SOURCE_PUSH    => '系统发放',
        ];
        return $status[$this->getAttribute('source')];
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

    public function getExpireTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getReceiveTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
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
     * 反向关联到优惠卷
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function goods()
    {
        return $this->belongsToMany(
            \App\Models\Goods::class,
            'coupon_receive_goods',
            'coupon_receive_id',
            'goods_id'
        );
    }

    /**
     * 用户领卷或发放已有的优惠卷到指定用户账户
     * @param Coupon $coupon
     * @param int $member_id
     * @param int $source
     * @return bool
     * @throws \Exception
     */
    public static function assign(Coupon $coupon, int $member_id, int $source = self::SOURCE_RECEIVE)
    {
        $receive                 = new static;
        $receive->member_id      = $member_id;
        $receive->coupon_name    = $coupon->coupon_name;
        $receive->coupon_type    = $coupon->coupon_type;
        $receive->discount       = $coupon->discount;
        $receive->discount_limit = $coupon->discount_limit;
        $receive->amount         = $coupon->amount;
        $receive->condition      = $coupon->condition;
        $receive->description    = $coupon->description;
        $receive->goods_limit    = $coupon->goods_limit;
        $receive->source         = $source;
        $receive->receive_time   = time();

        if ($coupon->expire_type == Coupon::EXPIRE_TYPE_DYNAMIC) { // 领取后生效
            $receive->expire_time = Carbon::now()->addDay($coupon->effective_time)->timestamp;
        } else { // 固定时间
            $receive->expire_time = strtotime($coupon->end_time . ' 23:59:59');
        }

        $coupon->receive()->save($receive);
        foreach ($coupon->goods as $item) {
            $receive->goods()->attach($item);
        }

        if ($coupon->tag_limit == Coupon::TAG_LIMIT_ON) {
            $member = Member::find($member_id);
            foreach ($coupon->tag as $id) {
                $member->tag()->detach($id);
                $member->tag()->attach($id);
            }
        }
        $coupon->received += 1;
        return $coupon->save();
    }
}
