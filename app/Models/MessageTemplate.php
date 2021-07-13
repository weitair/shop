<?php

namespace App\Models;

use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Message\Factory;
use Log;
use DB;

class MessageTemplate extends Model
{
    use SoftDeletes;

    protected $table   = 'message_template';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['key'];

    // 小程序模板消息开关
    const WEAPP_STATUS = 1;

    // 短信消息开关
    const SMS_STATUS = 1;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(string $key = '')
    {
        if (!$template = self::where('key', $key)->first()) {
            throw new AppException('参数错误，未查询到消息模板');
        }
        return $template;
    }

    /**
     * 发给指定的手机号
     * @param string $phone
     * @param array $content
     * @return bool
     */
    public function phone(string $phone, array $content = [])
    {
        try {
            $this->sms($phone, $content);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 发给用户
     * @param Member $member
     * @param array $sms
     * @param array $wechat
     * @return bool
     */
    public function member(Member $member, array $sms = [], array $wechat = [])
    {
        try {
            $this->sms($member->phone, $sms);
            $this->weapp($member, $wechat);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 发送短信
     * @param string $phone
     * @param array $content
     * @param int $expire // 验证码过期时间，默认十分钟
     * @return false
     */
    private function sms(string $phone, array $content, int $expire = 600)
    {
        if ($this->sms_status != self::SMS_STATUS) {
            return false;
        }

        $setting = Setting::getInstance('message.sms')->fetch();
        $result  = Factory::getInstance($setting)->template($this->sms_template_id)->send($phone, $content);

        $sms              = new Sms;
        $sms->phone       = $phone;
        $sms->content     = json_encode($content);
        $sms->status      = intval($result);
        $sms->send_time   = time();
        $sms->type        = $this->sms_type;
        $sms->template_id = $this->id;
        $sms->key         = $this->key;

        if ($sms->type == Sms::TYPE_CODE) {
            $sms->code        = $content['code'];
            $sms->expire_date = time() + $expire;
        }
        $sms->save();
    }

    private function weapp(Member $member, array $content = [])
    {
        if ($this->weapp_status != self::WEAPP_STATUS || empty($member->weapp)) {
            return false;
        }

        $config['driver'] = 'weapp';
        return Factory::getInstance($config)
            ->template($this->weapp_template_id)
            ->send($member->weapp->openid, $content);
    }
}
