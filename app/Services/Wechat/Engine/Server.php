<?php

namespace App\Services\Wechat\Engine;

use App\Exceptions\AppException;
use Log;

abstract class Server
{
    protected $config;
    public $app;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getAccessToken()
    {
        try {
            return $this->app->access_token->getToken();
            // {"errcode":42001,"errmsg":"access_token expired rid: 5f9a7148-03d74007-4b73a3fc"}
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            throw new AppException('获取 Access Token 失败');
        }
    }
}
