<?php

namespace Addon\Install\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $moduleNamespace = 'Addon\Install\Http\Controllers';

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::namespace($this->moduleNamespace)->group(module_path('Install', '/Routes/web.php'));
    }
}
