<?php

namespace App\Services\Transfer;

class Factory
{
    public static function getInstance(array $config)
    {
        $engine = $config['driver'] ?? 'wechat';
        $class  = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}
