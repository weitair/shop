<?php

namespace App\Services\Wechat\Engine;

use EasyWeChat\Factory;

class Base extends Server
{
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->app = Factory::officialAccount([
            'app_id'        => $config['app_id'],
            'secret'        => $config['app_secret'],
            'token'         => '',
            'response_type' => 'array',
        ]);
    }
}