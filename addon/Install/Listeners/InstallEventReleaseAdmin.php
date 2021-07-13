<?php

namespace Addon\Install\Listeners;

use Addon\Install\Events\InstallEvent;
use File;
use Str;

class InstallEventReleaseAdmin
{
    public function handle(InstallEvent $event)
    {
        $params = $event->params;

        File::copyDirectory(base_path('admin'), public_path('admin'));
        $admin = File::allFiles(public_path('admin/assets/js/'));

        foreach ($admin as $file) {
            $filename = $file->getBasename();
            if (Str::startsWith($filename, 'app')) {
                $realpath = $file->getRealPath();
                $content  = File::get($realpath);
                $content  = str_replace('{{WEITAIR_ROOT}}', $params['root'], $content);
                $content  = str_replace('{{WEITAIR_SECRET}}', $params['secret'], $content);
                File::put($realpath, $content);
            }
        }
    }
}
