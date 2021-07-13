<?php

namespace App\Services\Payment\Engine;

use App\Logics\Api\Setting;
use Yansongda\Pay\Pay;
use Log;

class Wechat
{
    private $config;

    private $response;

    public function __construct(array $config)
    {
        $setting = Setting::getInstance('payment.wechat')->fetch();

        $this->config = array_merge($config, [
            'mch_id'      => $setting['mch_id'],
            'key'         => $setting['mch_key'],
            'notify_url'  => config('app.url') . '/api/payment/notify',
//            'cert_client' => File::isFile($cert_client) ? $cert_client : '',
//            'cert_key'    => File::isFile($cert_key) ? $cert_key : '',
            'log'         => [
                'file'     => storage_path('logs/wechat/wechat.log'),
                'type'     => 'daily',
                'level'    => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                'max_file' => 90, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [
                'timeout'         => 10.0,
                'connect_timeout' => 10.0,
            ]
        ]);
    }

    public function payment()
    {
        try {
            $setting = Setting::getInstance('app.base')->fetch();

            $order = [
                'body'         => $setting['app_name'],
                'out_trade_no' => $this->config['payment_sn'],
                'total_fee'    => $this->config['payment_price'] * 100,
                'openid'       => $this->config['openid'],
            ];

            switch ($this->config['channel']) {
                case Setting::CHANNEL_WECHAT:
                    $setting                = Setting::getInstance('wechat.base')->fetch();
                    $this->config['app_id'] = $setting['app_id'];
                    $payment                = Pay::wechat($this->config)->mp($order);
                    break;
                case Setting::CHANNEL_WECHAT_APP:
                    $setting                    = Setting::getInstance('wechat.weapp')->fetch();
                    $this->config['miniapp_id'] = $setting['app_id'];
                    $payment                    = Pay::wechat($this->config)->miniapp($order);
                    break;
                case Setting::CHANNEL_H5:
                    $setting                = Setting::getInstance('wechat.base')->fetch();
                    $this->config['app_id'] = $setting['app_id'];
                    $payment                = Pay::wechat($this->config)->wap($order);
                    $payment->mweb          = $payment->getTargetUrl();
                    break;
            }

            if (!empty($payment->mweb)) {
                return ['mweb' => $payment->mweb];
            }
            return [
                'timeStamp' => $payment->timeStamp,
                'nonceStr'  => $payment->nonceStr,
                'package'   => $payment->package,
                'signType'  => $payment->signType,
                'paySign'   => $payment->paySign,
                'mweb'      => $payment->mweb,
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return null;
        }
    }

    public function notify()
    {
        try {
            $pay = Pay::wechat($this->config);
            $this->response = $pay->verify();
            return $pay->success();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    public function getResponse()
    {
        return $this->response;
    }
}
