<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        Route::pattern('id', '[0-9]+');

        parent::boot();
    }

    public function map()
    {
        $this->mapDefaultRoutes();

        $this->mapWebRoutes();

        $this->mapApiRoutes();
    }

    private function mapDefaultRoutes()
    {
        Route::namespace($this->namespace)->group(base_path('routes/default.php'));
    }

    private function mapWebRoutes()
    {
        $path  = base_path('routes/web/');
        $files = scandir($path);

        foreach ($files as $file) {
            if (strstr($file, '.php')) {
                Route::prefix('web')
                    ->middleware('api')
                    ->namespace($this->namespace . '\Web')
                    ->group($path . $file);
            }
        }
    }

    private function mapApiRoutes()
    {
        $path  = base_path('routes/api/');
        $files = scandir($path);

        foreach ($files as $file) {
            if (strstr($file, '.php')) {
                Route::prefix('api')
                    ->middleware('api')
                    ->namespace($this->namespace . '\Api')
                    ->group($path . $file);
            }
        }
    }
}
