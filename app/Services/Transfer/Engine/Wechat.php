<?php

namespace App\Services\Transfer\Engine;

use App\Logics\Api\Setting;
use Yansongda\Pay\Pay;
use Log;

class Wechat
{
    private $config;

    private $response;

    public function __construct(array $config)
    {
        $this->config = $config;

        $setting = Setting::getInstance('payment.wechat')->fetch();

        $this->config = array_merge(
            $this->config,
            [
                'mch_id'      => $setting['mch_id'],
                'key'         => $setting['mch_key'],
                'app_id'      => $config['app_id'],
                'cert_client' => base_path('cert/wechat/apiclient_cert.pem'),
                'cert_key'    => base_path('cert/wechat/apiclient_key.pem'),
                'log'         => [
                    'file'     => storage_path('logs/transfer/transfer.log'),
                    'type'     => 'daily',
                    'level'    => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                    'max_file' => 90, // optional, 当 type 为 daily 时有效，默认 30 天
                ],
                'http' => [
                    'timeout'         => 10.0,
                    'connect_timeout' => 10.0,
                ]
            ]
        );
    }

    public function payment()
    {
        try {
            $order = [
                'partner_trade_no' => $this->config['sn'],
                'openid'           => $this->config['openid'],
                'amount'           => $this->config['amount'] * 100,
                'check_name'       => 'NO_CHECK',      //NO_CHECK：不校验真实姓名\FORCE_CHECK：强校验真实姓名
//                're_user_name'   =>'张三',            //check_name为 FORCE_CHECK 校验实名的时候必须提交
                'desc'             => '支付到钱包',      //付款说明
                'spbill_create_ip' => get_client_ip(), //发起交易的IP地址
            ];
            $this->response = Pay::wechat($this->config)->transfer($order);

            if ($this->response->return_code == 'SUCCESS' && $this->response->result_code == 'SUCCESS') {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public function getResponse()
    {
        return $this->response;
    }
}
