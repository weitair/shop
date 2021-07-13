<?php

namespace App\Services\Payment;

class Factory
{
    public static function getInstance(array $config)
    {
        $class = __NAMESPACE__ . '\\Engine\\' . ucfirst($config['payment_channel']);
        return new $class($config);
    }
}
