<?php

namespace App\Logics\Web;

use App\Events\Account\LoginSuccessEvent;
use App\Events\Account\LoginFailEvent;
use App\Exceptions\AppException;
use App\Models\Module;
use App\Helper\Tree;
use Cache;
use Event;
use Hash;

class AccountAuth
{
    const ACCOUNT_ERROR   = '用户名或密码有误，注意区分大小写。';
    const ACCOUNT_LOCK    = '账号已被锁定，请稍后再试';
    const ACCOUNT_DISABLE = '账号已被禁用，请联系管理员处理';

    public $account;
    public $menu;

    /**
     * 用户登录
     * @param array $params
     *        string username
     *        string password
     * @return bool
     * @throws AppException
     */
    public function login(array $params)
    {
        $this->account = Account::where('username', $params['username'])->first();

        // 用户是存在的
        if (!empty($this->account)) {
            // 账号已被禁用
            if ($this->account->disable === Account::DISABLE_ON) {
                throw new AppException(self::ACCOUNT_DISABLE);
            }

            // 账号已被锁定
            if ($this->account->lock_time >= time()) {
                throw new AppException(self::ACCOUNT_LOCK);
            }

            // 比对密码是否输入正确
            if (!Hash::check($params['password'], $this->account->password)) {
                Event::dispatch(new LoginFailEvent($this->account));
                throw new AppException(self::ACCOUNT_ERROR);
            }

            $this->getPower();
            Event::dispatch(new LoginSuccessEvent($this->account));
            return true;
        }
        throw new AppException(self::ACCOUNT_ERROR);
    }

    public static function logout()
    {
        return Cache::store('file')->delete(get_token());
    }

    private function getPower()
    {
        if ($role = Role::with('module')->find($this->account->role_id)) {
            $result = [];
            foreach ($role->module as $item) {
                // 处理前端，插件层级全部调整为顶级
                if ($item->addon_key) {
                    $item->parent_id = 0;
                    $item->level = 0;
                }

                $result[] = [
                    'id'         => $item->id,
                    'parent_id'  => $item->parent_id,
                    'path'       => $item->client_router,
                    'redirect'   => $item->redirect,
                    'type'       => $item->type,
                    'level'      => $item->level,
                    'hidden'     => $item->hidden == Module::HIDDEN,
                    'addon'      => $item->addon,
                    'meta'       => [
                        'title'  => $item->module_name,
                        'icon'   => $item->icon,
                        'type'   => $item->type,
                    ],
                ];
            }
            $this->power = Tree::make($result);
        }
    }
}
