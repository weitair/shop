<?php

namespace App\Listeners\Member;

use App\Events\Member\LoginEvent;

class LoginEventBase
{
    public function handle(LoginEvent $event)
    {
        $member = $event->member;
        $member->last_login_time = time();
        $member->last_login_ip   = get_client_ip();
        $member->save();
    }
}
