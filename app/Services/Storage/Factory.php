<?php

namespace App\Services\Storage;

use App\Models\Setting;

class Factory
{
    public static function getInstance(string $action)
    {
        // 获取系统设置，判断本地存储还是云端存储，以及云端账号信息
        $setting = Setting::getInstance('system.storage')->fetch();
        // 获取配置文件中的文件配置信息
        $config  = config('filesystems.disks.' . $action);
        // 合并系统设置以及文件配置信息
        $config  = array_merge($config, $setting);
        // 默认本地存储
        $engine  = $config['driver'] ?? 'local';
        $class   = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}
