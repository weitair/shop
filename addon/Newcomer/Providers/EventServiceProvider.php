<?php

namespace Addon\Newcomer\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Addon\Newcomer\Events\RegisterEvent' => [
            'Addon\Newcomer\Listeners\RegisterEventBase',
        ],
    ];
}
