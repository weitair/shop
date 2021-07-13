<?php

namespace App\Http\Middleware;

use App\Exceptions\AppException;
use Illuminate\Http\Request;
use Closure;
use File;

class CheckSign
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        $sign = get_sign();
        $timestamp = floor(get_timestamp() / 1000);
        $expire = $timestamp + (5 * 60); //5分钟后接口过期

        if (strpos(strtolower($request->header('content-type')), 'multipart/form-data') !== false) {
            return $next($request);
        }

        if ($expire < time() || empty($sign)) {
            throw new AppException('签名错误，拒绝访问');
        }

        ksort($input);
        $params = [];
        foreach ($input as $key => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    $params[] = $key . '=' . urldecode(http_build_query($value));
                } else {
                    $params[] = $key . '=' . $value;
                }
            }
        }

        $secret = File::get(base_path('secret.key'));
        if (hash_equals(md5(join('&', $params) . $secret), $sign) === true) {
            return $next($request);
        } else {
            throw new AppException('签名错误，拒绝访问');
        }
    }
}
