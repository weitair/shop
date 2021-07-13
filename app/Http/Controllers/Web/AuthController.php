<?php

namespace App\Http\Controllers\Web;

use App\Logics\Web\AccountAuth;
use App\Models\Setting;

class AuthController extends Controller
{
    public function index()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|min:6|max:20'
        ]);

        $auth = new AccountAuth;
        if ($auth->login($this->request->all()) === true) {
            $this->renderSuccess([
                'token'    => $auth->account->token,
                'username' => $auth->account->username,
                'realname' => $auth->account->realname,
                'avatar'   => $auth->account->avatar,
                'power'    => $auth->power,
                'map'      => Setting::getInstance('app.location')->fetch()
            ], '登录成功');
        }
    }

    public function logout()
    {
        if (AccountAuth::logout()) {
            $this->renderSuccess([], '已退出');
        }
        $this->renderError([], '出错了');
    }

    public function setting()
    {
        $result['system']    = Setting::getInstance('system.base')->fetch();
        $result['copyright'] = Setting::getInstance('system.copyright')->fetch();

        $this->renderSuccess($result);
    }
}
