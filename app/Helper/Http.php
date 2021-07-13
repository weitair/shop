<?php

namespace App\Helper;

use App\Exceptions\AppException;
use GuzzleHttp\Client;
use Log;

class Http
{
    public static function get(string $url, array $params = [])
    {
        try {
            $client = new Client();
            $result = $client->get($url, [
                'headers' => [
                    'Content-type' => 'application/json'
                ],

                'json' => $params
            ]);
            return $result->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            throw new AppException('网络连接异常');
        }
    }

    public static function post(string $url, array $params = [])
    {
        try {
            $client = new Client();
            $result = $client->post($url, [
                    'headers' => [
                        'Content-type' => 'application/json'
                    ],

                    'json' => $params
                ]);
            return $result->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            throw new AppException('网络连接异常');
        }
    }

    public static function postForm(string $url, array $params = [])
    {
        try {
            $client = new Client();
            $result = $client->post($url, [
                    'headers' => [
                        'Content-type' => 'application/x-www-form-urlencoded'
                    ],

                    'form_params' => $params
                ]);
            return $result->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            throw new AppException('网络连接异常');
        }
    }
}
