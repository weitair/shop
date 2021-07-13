<?php

namespace App\Services\Message\Engine;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use AlibabaCloud\Client\AlibabaCloud;
use App\Models\Setting;
use Log;

class Ali extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function send(string $phoneNumber, array $content=[])
    {
        try {
            // 是否开启了全局短信设置
            if ($this->config['status'] != Setting::SMS) {
                return false;
            }

            // 模板为空
            if (empty($this->template)) {
                return false;
            }

            // 手机号
            if (empty($phoneNumber)) {
                return false;
            }

            AlibabaCloud::accessKeyClient(
                $this->config['app_id'],
                $this->config['app_secret']
            )
                ->regionId('cn-chengdu')
                ->asDefaultClient();

            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->host('dysmsapi.aliyuncs.com')
                ->method('POST')
                ->options([
                    'query' => [
                        'RegionId' => "default",
                        'TemplateCode' => $this->template,
                        'SignName' => $this->config['sign'],
                        'PhoneNumbers' => $phoneNumber,
                        'TemplateParam' => empty($content) ? '' : json_encode($content),
                    ],
                ])
                ->request()
                ->toArray();

            if (strtolower($result['Message']) !== 'ok') {
                Log::error($result['Message'] . PHP_EOL);
                return false;
            }
            return true;
        } catch (ClientException $e) {
            Log::error($e->getErrorMessage() . PHP_EOL);
        } catch (ServerException $e) {
            Log::error($e->getErrorMessage() . PHP_EOL);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
