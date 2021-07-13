<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods:POST,GET,PUT,OPTIONS,DELETE');
        header('Access-Control-Allow-Credentials: false');
        header('Access-Control-Allow-Headers: *');
        return $next($request);
    }
}
