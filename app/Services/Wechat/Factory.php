<?php

namespace App\Services\Wechat;

use App\Logics\Api\Setting;

class Factory
{
    public static function getInstance(string $driver)
    {
        $config = Setting::getInstance('wechat.' . $driver)->fetch();
        $engine = !empty($driver) ? $driver : 'base';
        $class  = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}
