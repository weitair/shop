<?php

namespace Addon\Install\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Addon\Install\Events\InstallEvent' => [
            'Addon\Install\Listeners\InstallEventBase',
            // 安装插件
            'Addon\Install\Listeners\InstallEventInstallAddon',
            // 初始化管理员账号
            'Addon\Install\Listeners\InstallEventInitAccount',
            // 导入页面模板
            'Addon\Install\Listeners\InstallEventImportTemplate',
            // 发布后台页面
            'Addon\Install\Listeners\InstallEventReleaseAdmin',
        ]
    ];
}
