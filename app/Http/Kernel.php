<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        \App\Http\Middleware\Cors::class,
    ];

    protected $middlewareGroups = [
        'api' => [
            'throttle:60,1',
        ],
    ];

    protected $routeMiddleware = [
        'sign'          => \App\Http\Middleware\CheckSign::class,
        'auth'          => \App\Http\Middleware\Authenticate::class,
        'auth.admin'    => \App\Http\Middleware\AuthenticateAdmin::class,
        'permission'    => \App\Http\Middleware\Permission::class,
        'throttle'      => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'seller'        => \Addon\Fenxiao\Http\Middleware\Authenticate::class,
    ];

    protected $middlewarePriority = [
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
