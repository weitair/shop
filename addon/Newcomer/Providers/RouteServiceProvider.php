<?php

namespace Addon\Newcomer\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $moduleNamespace = 'Addon\Newcomer\Http\Controllers';

    public function boot()
    {
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    public function map()
    {
        $this->mapWebRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::prefix('web/newcomer')
            ->middleware('api')
            ->namespace($this->moduleNamespace . '\Web')
            ->group(module_path('Newcomer', '/Routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api/newcomer')
            ->middleware('api')
            ->namespace($this->moduleNamespace . '\Api')
            ->group(module_path('Newcomer', '/Routes/api.php'));
    }
}
