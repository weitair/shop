<?php

namespace App\Listeners\Order;

use Addon\Coupon\Logics\Api\CouponReceive;
use App\Events\Order\SubmitEvent;
use App\Exceptions\AppException;
use App\Logics\Api\Member;

class SubmitEventCoupon
{
    public function handle(SubmitEvent $event)
    {
        $order = $event->order;

        if ($order->coupon_id) {
            $coupon = Member::user()->coupon()
                ->where('id', $order->coupon_id)
                ->where('status', CouponReceive::STATUS_UNUSED)
                ->first();

            if (empty($coupon)) {
                throw new AppException('无效的优惠卷');
            }
            $coupon->status    = CouponReceive::STATUS_USED;
            $coupon->used_time = time();
            $coupon->coupon->used += 1;

            $coupon->push();
        }
    }
}
