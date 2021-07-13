<?php

namespace App\Listeners\Account;

use App\Events\Account\LoginSuccessEvent;
use App\Logics\Web\AccountLogin;
use App\Exceptions\AppException;
use App\Models\Module;
use Cache;
use Log;

class LoginSuccessEventBase
{
    public function handle(LoginSuccessEvent $event)
    {
        // 记录登录日志
        AccountLogin::write($event->account, AccountLogin::STATUS_SUCCESS);

        // 更新账号信息
        $event->account->token           = token_hash($event->account->id);
        $event->account->last_login_time = time();
        $event->account->last_login_ip   = get_client_ip();
        $event->account->lock_time       = 0;
        $event->account->save();

        $router = [];
        // 缓存服务端接口权限
        if ($role = $event->account->role) {
            $module = $role->module()->get();

            try {
                foreach ($module as $item) {
                    if (!empty($item->server_router)) {
                        $array      = explode('.', $item->server_router);
                        $controller = $array[0];
                        $action     = $array[1];
                        if ($action == 'index' && $item->extend == Module::EXTEND) {
                            $router[$controller]['extend'] = true;
                        }
                        $router[$controller][] = $action;
                    }
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage() . PHP_EOL);
                Log::error($e->getTraceAsString() . PHP_EOL);
                throw new AppException('服务端路由设置错误');
            }
        }
        // 缓存用户数据
        $data = [
            'id'     => $event->account->id,
            'router' => $router
        ];
        Cache::store('file')->put($event->account->token, $data, 3600 * 24);
    }
}
