<?php

namespace App\Listeners\Order;

use Addon\Coupon\Logics\Api\CouponReceive;
use App\Events\Order\CloseEvent;
use App\Logics\Api\Member;

class CloseEventCoupon
{
    /**
     * 返还优惠卷
     * @param  CloseEvent  $event
     * @return void
     */
    public function handle(CloseEvent $event)
    {
        $order     = $event->order;
        $coupon_id = $order->coupon_id;

        // TODO 售后关闭订单不返还优惠卷
        if ($coupon = Member::find($order->member_id)->coupon()->with('coupon')->find($coupon_id)) {
            $coupon->status        = CouponReceive::STATUS_UNUSED;
            $coupon->coupon->used -= 1;
            $coupon->push();
        }
    }
}
