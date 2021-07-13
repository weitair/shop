<?php

namespace App\Listeners\Member;

use App\Events\Member\WeappEvent;

class WeappEventUpdate
{
    public function handle(WeappEvent $event)
    {
        $member = $event->member;
        $params = $event->params;

        if (isset($params['userinfo']) && !empty($params['userinfo'])) {
            $userinfo         = json_decode($params['userinfo'], true);
            $member->nickname = $member->getOriginal('nickname')
                ? $member->getOriginal('nickname')
                : preg_replace('/[\xf0-\xf7].{3}/', '', $userinfo['nickName']);
            $member->avatar   = $member->getOriginal('avatar') ? $member->getOriginal('avatar') : $userinfo['avatarUrl'];
            $member->gender   = $member->gender ? $member->gender : $userinfo['gender'];
            $member->country  = $member->country ? $member->country : $userinfo['country'];
            $member->province = $member->province ? $member->province : $userinfo['province'];
            $member->city     = $member->city ? $member->city : $userinfo['city'];
            $member->save();
        }
    }
}
