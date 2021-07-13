<?php

namespace Addon\Install\Listeners;

use Addon\Install\Events\InstallEvent;
use App\Helper\Http;

class InstallEventBase
{
    public function handle(InstallEvent $event)
    {
        $params = [
            'SERVER_SOFTWARE' => $_SERVER['SERVER_SOFTWARE'],
            'REQUEST_URI'     => $_SERVER['REQUEST_URI'],
        ];

        $data = [
            'host'   => $_SERVER['SERVER_ADDR'],
            'port'   => $_SERVER['SERVER_PORT'],
            'domain' => $_SERVER['SERVER_NAME'],
            'server' => $_SERVER['SERVER_SOFTWARE'],
            'php'    => PHP_VERSION,
            'mysql'  => mysqli_get_client_version(),
            'params' => json_encode($params),
        ];

        Http::post('https://www.weitair.com/api/install', $data);
    }
}
