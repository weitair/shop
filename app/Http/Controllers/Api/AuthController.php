<?php

namespace App\Http\Controllers\Api;

use App\Models\MessageTemplate;
use App\Logics\Api\Member;
use App\Models\Setting;

class AuthController extends Controller
{
    /**
     * 小程序登录
     * @throws \App\Exceptions\AppException
     */
    public function weapp()
    {
        $this->validate([
            'code' => 'required|string',
        ]);

        $model = new Member;
        if ($model->weappLogin()) {
            $this->renderSuccess([
                'token' => $model->member->token
            ]);
        }
        $this->renderError([], '登录失败');
    }

    /**
     * 小程序一键注册
     */
    public function weappRegister()
    {
        $this->validate([
            'code'          => 'required|string',
            'iv'            => 'required|string',
            'encryptedData' => 'required|string',
        ]);

        $model = new Member;
        if ($model->weappRegister()) {
            $this->renderSuccess([
                'token' => $model->member->token
            ]);
        }
        $this->renderError([], '登录失败');
    }

    /**
     * 公众号登录
     */
    public function wechat()
    {
        $this->validate([
            'code' => 'required|string',
        ]);

        $model = new Member;
        if ($model->wechatLogin()) {
            $this->renderSuccess([
                'token' => $model->member->token
            ]);
        }
        $this->renderError([
            'userinfo' => $model->member->userinfo
        ], '登录失败');
    }

    /**
     * 获取公众号 APP_ID
     */
    public function appid()
    {
        $setting = Setting::getInstance('wechat.base')->fetch();
        $this->renderSuccess($setting['app_id']);
    }

    /**
     * 密码登录
     * @throws \App\Exceptions\AppException
     */
    public function password()
    {
        $this->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
        ]);

        $model = new Member;
        if ($model->passwordLogin()) {
            $this->renderSuccess([
                'token' => $model->member->token
            ]);
        }
        $this->renderError([], '登录失败');
    }

    /**
     * 验证码登录
     * @throws \Exception
     */
    public function code()
    {
        $this->validate([
            'phone' => 'required|string',
            'code'  => 'required|string',
        ]);

        $model = new Member;
        if ($model->codeLogin()) {
            $this->renderSuccess([
                'token' => $model->member->token
            ]);
        }
        $this->renderError([], '验证码错误或已过期');
    }

    /**
     * 用户注册
     */
    public function register()
    {
        $this->validate([
            'phone'    => 'required|string',
            'password' => 'required|string',
            'code'     => 'required|string',
        ]);

        $model = new Member;
        if ($model->register()) {
            $this->renderSuccess([
                'token' => $model->member->token
            ]);
        }
        $this->renderError([], '验证码错误或已过期');
    }

    /**
     * 登录短信验证码
     */
    public function loginCode()
    {
        $this->validate([
            'phone' => 'required|string',
        ]);

        $result = MessageTemplate::getInstance('LOGIN_CODE')
            ->phone($this->request->post('phone'), ['code' => get_random_number(6)]);

        if ($result) {
            $this->renderSuccess([], '短信发送成功');
        }
        $this->renderError([], '短信发送失败');
    }

    /**
     * 注册短信验证码
     */
    public function registerCode()
    {
        $this->validate([
            'phone' => 'required|string',
        ]);

        $result = MessageTemplate::getInstance('REGISTER_CODE')
            ->phone($this->request->post('phone'), ['code' => get_random_number(6)]);

        if ($result) {
            $this->renderSuccess([], '短信发送成功');
        }
        $this->renderError([], '短信发送失败');
    }
}
