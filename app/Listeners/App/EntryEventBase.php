<?php

namespace App\Listeners\App;

use App\Events\App\EntryEvent;
use Illuminate\Http\Request;
use App\Logics\Api\Member;
use App\Helper\Date;
use App\Models\Uv;

class EntryEventBase
{
    public function handle(EntryEvent $event)
    {
        $request = Request::capture();
        $ip      = get_client_ip();
        $date    = Date::today();

        // 查询当天的访问记录
        $model = Uv::where('client_ip', $ip)
            ->whereBetween('entry_time', [$date['start'], $date['end']])
            ->first();

        // 未访问过，记录访问历史
        if (empty($model)) {
            $model = new Uv;
            $model->client_ip = $ip;
            $model->entry_time = time();
            $model->user_agent = $request->header('user-agent');
            $model->save();
        }

        // 如果是已登录的用户,记录该用户本次登录的信息
        if (Member::id()) {
            $member = Member::user();
            $member->last_login_time = time();
            $member->last_login_ip = $ip;
            $member->save();
        }
    }
}
