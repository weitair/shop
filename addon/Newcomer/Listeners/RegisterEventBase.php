<?php

namespace Addon\Newcomer\Listeners;

use App\Events\Growth\ChangeEvent as GrowthChangeEvent;
use Addon\Newcomer\Events\RegisterEvent;
use Addon\Coupon\Models\CouponReceive;
use Addon\Coupon\Models\Coupon;
use App\Events\Point\ChangeEvent;
use App\Models\Setting;
use App\Models\Growth;
use App\Models\Point;
use Event;

class RegisterEventBase
{
    public function handle(RegisterEvent $event)
    {
        $member  = $event->member;

        if ($setting = Setting::getInstance('newcomer.base')->fetch()) {
            // 奖励积分
            if ($setting['point_status'] == 1) {
                Event::dispatch(new ChangeEvent($member, $setting['point'], Point::INTRO_REGISTER));
            }

            // 奖励成长值
            if ($setting['growth_status'] == 1) {
                Event::dispatch(new GrowthChangeEvent($member, $setting['growth'], Growth::FROM_REGISTER));
            }

            // 奖励优惠卷
            if ($setting['coupon_status'] == 1) {
                foreach ($setting['coupon'] as $item) {
                    // 优惠卷可能不存在，所以判断一下
                    if ($coupon = Coupon::find($item['id'])) {
                        CouponReceive::assign($coupon, $member->id, CouponReceive::SOURCE_PUSH);
                    }
                }
            }
        }
    }
}
