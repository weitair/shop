<?php

namespace App\Listeners\Member;

use App\Events\Member\WechatEvent;

class WechatEventUpdate
{
    public function handle(WechatEvent $event)
    {
        $member = $event->member;
        $params = $event->params;

        if (isset($params['userinfo']) && !empty($params['userinfo'])) {
            $userinfo         = json_decode($params['userinfo'], true);
            $member->nickname = $member->getOriginal('nickname')
                ? $member->getOriginal('nickname')
                : preg_replace('/[\xf0-\xf7].{3}/', '', $userinfo['nickname']);
            $member->avatar   = $member->getOriginal('avatar') ? $member->getOriginal('avatar') : $userinfo['headimgurl'];
            $member->gender   = $member->gender ? $member->gender : $userinfo['sex'];
            $member->country  = $member->country ? $member->country : $userinfo['country'];
            $member->province = $member->province ? $member->province : $userinfo['province'];
            $member->city     = $member->city ? $member->city : $userinfo['city'];

            $member->wechat()->updateOrCreate(
                ['openid' => $userinfo['openid']],
            )->save();

            $member->save();
        }
    }
}
