<?php

namespace Addon\Install\Listeners;

use Addon\Install\Events\InstallEvent;
use Hash;
use DB;

class InstallEventInitAccount
{
    public function handle(InstallEvent $event)
    {
        $params = $event->params;

        DB::table('account')->delete();
        DB::table('account')->insert([
            'role_id'  => 1,
            'username' => $params['username'],
            'password' => Hash::make($params['password'])
        ]);
    }
}
