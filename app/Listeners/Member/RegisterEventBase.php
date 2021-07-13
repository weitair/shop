<?php

namespace App\Listeners\Member;

use App\Events\Member\RegisterEvent;
use Nwidart\Modules\Facades\Module;
use Event;

class RegisterEventBase
{
    public function handle(RegisterEvent $event)
    {
        $member = $event->member;

        // 新用户注册事件，发放积分和优惠卷
        if (Module::has('Newcomer')) {
            Event::dispatch(new \Addon\Newcomer\Events\RegisterEvent($member));
        }

        // 邀请新用户事件，有邀请者才处理事件
        if (Module::has('Invite')) {
            if ($member->invite_id > 0) {
                Event::dispatch(new \Addon\Invite\Events\InviteEvent($member));
            }
        }

        // 处理分销商事件，人人分销添加分销商、邀请下级记录关系链
        if (Module::has('Fenxiao')) {
            Event::dispatch(new \Addon\Fenxiao\Events\RegisterEvent($member));
        }
    }
}
