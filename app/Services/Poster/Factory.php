<?php

namespace App\Services\Poster;

use Log;

class Factory
{
    public static function getInstance(array $config)
    {
        $engine = $config['driver'] ?? 'goods';
        $class  = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}