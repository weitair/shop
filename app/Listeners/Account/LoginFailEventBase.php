<?php

namespace App\Listeners\Account;

use App\Events\Account\LoginFailEvent;
use App\Logics\Web\AccountLogin;
use App\Models\Setting;

class LoginFailEventBase
{
    public function handle(LoginFailEvent $event)
    {
        // 记录登录日志
        AccountLogin::write($event->account, AccountLogin::STATUS_FAIL);

        $lock                = Setting::LOCK;
        $limited_time_length = 15;
        $fail_times          = 3;
        $lock_time_length    = 10;

        if ($setting = Setting::getInstance('system.security')->fetch()) {
            $lock                = $setting['lock'];
            $fail_times          = $setting['fail_times'];
            $limited_time_length = $setting['limited_time_length'];
            $lock_time_length    = $setting['lock_time_length'];
        }

        if ($lock == Setting::LOCK) {
            $fails = AccountLogin::fails($event->account, $limited_time_length);

            // 锁定账号
            if ($fails >= $fail_times) {
                $event->account->lock_time = time() + $lock_time_length * 60;
                $event->account->save();
            }
        }
    }
}
