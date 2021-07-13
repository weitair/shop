<?php

namespace App\Listeners\Order;

use Addon\Coupon\Logics\Api\CouponReceive;
use App\Events\Order\CreateEvent;
use App\Logics\Api\Member;

/**
 * 使用优惠卷
 * Class CreateEventQuota
 * @package App\Listeners\Order
 */
class CreateEventCoupon
{
    public function handle(CreateEvent $event)
    {
        $order = $event->order;

        if (!empty($order->coupon_id)) {
            $detail = Member::user()->coupon()->findOrFail($order->coupon_id);

            // 是否达到使用门槛
            if ($detail->condition == 0 || $detail->condition <= $order->goods_price) {
                switch ($detail->coupon_type) {
                    case CouponReceive::COUPON_TYPE_MINUS:
                        $order->coupon_price = $detail->amount;
                        break;
                    case CouponReceive::COUPON_TYPE_DISCOUNT:
                        $discount_limit = $detail->discount_limit * 100;
                        $goods_price    = $order->goods_price * 100;
                        $amount         = bcmul($goods_price, $detail->discount / 10, 2);
                        $discount       = $goods_price - $amount;

                        // 最多优惠大于 0，说明有优惠限制，如果超过这个值，将按照最多优惠金额计算
                        if ($discount_limit > 0) {
                            $discount = $discount_limit < $discount ? $discount_limit : $discount;
                        }
                        $order->coupon_price = bcdiv($discount, 100, 2);
                        break;
                }
            }
        }
    }
}
