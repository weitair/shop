<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Closure;
use Cache;

class Permission
{
    public function handle(Request $request, Closure $next)
    {
        if ($cache = Cache::store('file')->get(get_token())) {
            $router     = $cache['router'];
            $array      = explode('.', Route::getCurrentRoute()->getName());
            $controller = $array[0];
            unset($array[0]);

            if (isset($router[$controller])) {
                if (isset($router[$controller]['extend'])) {
                    return $next($request);
                }
                if (array_intersect($router[$controller], $array)) {
                    return $next($request);
                }
            }
        }
        Response::create('权限不足，无法操作', Response::HTTP_FORBIDDEN)->send();
        exit;
    }
}
