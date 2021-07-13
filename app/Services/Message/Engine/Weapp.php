<?php

namespace App\Services\Message\Engine;

use App\Services\Wechat\Factory;
use Log;

class Weapp extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function send(string $openid, array $content)
    {
        try {
            if (empty($openid) || empty($this->template)) {
                return false;
            }

            $content['template_id'] = $this->template;
            $content['touser']      = $openid;

            $wechat = Factory::getInstance('weapp');
            $result = $wechat->app->subscribe_message->send($content);

            if ($result['errcode'] != 0) {
                Log::error($result['errmsg'] . PHP_EOL);
                return false;
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
