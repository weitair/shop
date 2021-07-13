<?php

namespace App\Logics\Api;

use App\Models\Member as MemberModel;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Member\RegisterEvent;
use App\Events\Member\WechatEvent;
use App\Events\Member\WeappEvent;
use App\Events\Member\LoginEvent;
use App\Exceptions\AppException;
use App\Services\Wechat\Factory;
use Illuminate\Http\Request;
use App\Models\Sms;
use Cache;
use Event;
use Hash;
use Log;
use DB;

class Member extends MemberModel
{
    const ACCOUNT_ERROR     = '用户名或密码有误，注意区分大小写';
    const SYSTEM_ERROR      = '系统繁忙，请稍候在试';
    const ACCOUNT_EXISTED   = '该手机号已注册，请直接登录';
    const ACCOUNT_NOT_EXIST = '该手机号未注册';

    /**
     * 覆写父类 order, 因为需要增加是否已删除的条件
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class)->where('delete_status', Order::DELETE_STATUS_OFF);
    }

    public $member;

    /**
     * 小程序登录
     * @return bool
     * @throws \Exception
     */
    public function weappLogin()
    {
        try {
            DB::beginTransaction();
            $params      = Request::capture()->all();
            $wechat      = Factory::getInstance('weapp');
            $session     = $wechat->getSession($params['code']);
            $openid      = $session['openid'];
            $session_key = $session['session_key'];
            $token       = md5($session_key . $openid);

            $this->member = self::whereHas('weapp', function (Builder $query) use ($session) {
                $query->where('openid', $session['openid']);
            }, '>', 0)->first();

            if ($this->member) {
                $this->member->weapp()->updateOrCreate(
                    ['openid'      => $session['openid']],
                    ['session_key' => $session['session_key']],
                )->save();

                Event::dispatch(new LoginEvent($this->member));
                $this->member->token = $token;
                Cache::put($this->member->token, $this->member->id, 3600 * 24 * 7);
                DB::commit();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 小程序注册并登录
     * @return bool
     * @throws \Exception
     */
    public function weappRegister()
    {
        try {
            DB::beginTransaction();
            $params      = Request::capture()->all();
            $wechat      = Factory::getInstance('weapp');
            $session     = $wechat->getSession($params['code']);
            $openid      = $session['openid'];
            $session_key = $session['session_key'];
            $unionid     = isset($session['unionid']) ? $session['unionid'] : '';
            $phone       = $wechat->getPhone($session_key, $params['iv'], $params['encryptedData']);
            $token       = md5($session_key . $openid);

            if (empty($this->member = self::where('phone', $phone)->first())) {
                $info['point']         = 0;
                $info['growth']        = 0;
                $info['phone']         = $phone;
                $info['unionid']       = $unionid;
                $info['fenxiao_id']    = isset($params['fenxiao_id']) ? intval($params['fenxiao_id']) : 0;
                $info['invite_id']     = isset($params['invite_id']) ? intval($params['invite_id']) : 0;
                $info['scene']         = isset($params['scene']) ? $params['scene'] : '';
                $info['channel']       = self::CHANNEL_WECHAT_APP;
                $info['register_time'] = time();
                $this->member = self::create($info);
                Event::dispatch(new WeappEvent($this->member, $params));
                Event::dispatch(new RegisterEvent($this->member));
            } else {
                Event::dispatch(new WeappEvent($this->member, $params));
            }

            $this->member->weapp()->updateOrCreate(
                ['openid'      => $session['openid']],
                ['session_key' => $session['session_key']],
            )->save();

            Event::dispatch(new LoginEvent($this->member));
            $this->member->token = $token;
            Cache::put($this->member->token, $this->member->id, 3600 * 24 * 7);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public function wechatLogin()
    {
        $wechat = Factory::getInstance('base');
        $user   = $wechat->app->oauth->user();
        $openid = $user->id;
        $token  = md5($openid . time());

        $this->member = self::whereHas('wechat', function (Builder $query) use ($openid) {
            $query->where('openid', $openid);
        }, '>', 0)->first();

        if ($this->member) {
            Event::dispatch(new LoginEvent($this->member));
            $this->member->token = $token;
            Cache::put($this->member->token, $this->member->id, 3600 * 24 * 7);
            DB::commit();
            return true;
        }
        $this->member = new static;
        $this->member->userinfo = json_encode($user->original);
        return false;
    }

    /**
     * 账号密码登录
     * @return bool
     * @throws AppException
     */
    public function passwordLogin()
    {
        $params = Request::capture()->all();
        if ($this->member = self::where('phone', $params['phone'])->first()) {
            // 比对密码是否输入正确
            if (!Hash::check($params['password'], $this->member->password)) {
                throw new AppException(self::ACCOUNT_ERROR);
            }

            Event::dispatch(new WechatEvent($this->member, $params));
            Event::dispatch(new LoginEvent($this->member));
            $this->member->token = md5($this->member->id . $this->member->phone . time());
            Cache::put($this->member->token, $this->member->id, 3600 * 24 * 7);
            return true;
        }
        throw new AppException(self::ACCOUNT_NOT_EXIST);
    }

    /**
     * 验证码登录，未注册手机自动注册
     * @return bool
     * @throws \Exception
     */
    public function codeLogin()
    {
        $params = Request::capture()->all();
        $result = Sms::where('key', 'LOGIN_CODE')
            ->where('used', Sms::UNUSED)
            ->where('code', $params['code'])
            ->where('phone', $params['phone'])
            ->where('expire_date', '>=', time())
            ->first();

        if (empty($result)) return false;

        $result->used = Sms::USED;
        $result->save();

        if (!$this->member = self::where('phone', $params['phone'])->first()) {
            if (!$this->memberRegister($params)) {
                throw new AppException(self::SYSTEM_ERROR);
            }
        } else {
            Event::dispatch(new WechatEvent($this->member, $params));
        }

        Event::dispatch(new LoginEvent($this->member));
        $this->member->token = md5($this->member->id . $this->member->phone . time());
        Cache::put($this->member->token, $this->member->id, 3600 * 24 * 7);
        return true;
    }

    public function register()
    {
        $params = Request::capture()->all();
        $result = Sms::where('key', 'REGISTER_CODE')
            ->where('used', Sms::UNUSED)
            ->where('code', $params['code'])
            ->where('phone', $params['phone'])
            ->where('expire_date', '>=', time())
            ->first();

        if (empty($result)) return false;

        $result->used = Sms::USED;
        $result->save();

        if (self::where('phone', $params['phone'])->first()) {
            throw new AppException(self::ACCOUNT_EXISTED);
        }

        // 账号不存在，立即注册
        if ($this->memberRegister($params)) {
            $this->member->token = md5($this->member->id . $this->member->phone . time());
            Cache::put($this->member->token, $this->member->id, 3600 * 24 * 7);
            return true;
        }
        throw new AppException(self::SYSTEM_ERROR);
    }

    private function memberRegister(array $params)
    {
        try {
            DB::beginTransaction();
            $data['point']         = 0;
            $data['growth']        = 0;
            $data['phone']         = $params['phone'];
            $data['channel']       = $params['channel'];
            $data['fenxiao_id']    = isset($params['fenxiao_id']) ? intval($params['fenxiao_id']) : 0;
            $data['invite_id']     = isset($params['invite_id']) ? intval($params['invite_id']) : 0;
            $data['scene']         = isset($params['scene']) ? $params['scene'] : '';
            $data['register_time'] = time();

            $this->member = self::create($data);
            $this->member->password = isset($params['password']) && !empty($params['password']) ? Hash::make($params['password']) : '';
            $this->member->save();

            Event::dispatch(new WechatEvent($this->member, $params));
            Event::dispatch(new RegisterEvent($this->member));
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 获取用户详细信息，不包含敏感信息
     * @return mixed
     */
    public static function detail()
    {
        return self::findOrFail(self::id())->makeHidden('password');
    }

    /**
     * 获取用户 Eloquent
     * 自动根据请求中的 token 参数从缓存中获取账户ID
     * 并根据账户ID获取到该账户的模型
     * @return mixed
     */
    public static function user()
    {

        return self::with(['wechat', 'weapp'])->findOrFail(self::id());
    }

    /**
     * 根据请求中 token 参数从缓存中获取账户ID
     * @return mixed
     */
    public static function id()
    {
        return Cache::get(get_token());
    }

    /**
     * 修改用户信息
     * @param array $data
     * @return mixed
     */
    public static function change(array $data)
    {
        return self::detail()->fill($data)->save();
    }
}
