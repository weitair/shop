<?php

namespace Addon\Coupon\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $moduleNamespace = 'Addon\Coupon\Http\Controllers';

    public function boot()
    {
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::prefix('web/coupon')
            ->middleware('api')
            ->namespace($this->moduleNamespace . '\Web')
            ->group(module_path('Coupon', '/Routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api/coupon')
            ->middleware('api')
            ->namespace($this->moduleNamespace . '\Api')
            ->group(module_path('Coupon', '/Routes/api.php'));
    }
}
