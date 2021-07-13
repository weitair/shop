<?php

namespace App\Services\Message;

class Factory
{
    public static function getInstance (array $config)
    {
        $engine = $config['driver'] ?? 'ali';
        $class  = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}
