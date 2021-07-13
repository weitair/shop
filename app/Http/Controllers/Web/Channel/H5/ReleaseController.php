<?php

namespace App\Http\Controllers\Web\Channel\H5;

use App\Http\Controllers\Web\Controller;
use App\Models\Setting;
use File;
use Log;
use Str;

class ReleaseController extends Controller
{
    public function index()
    {
        $this->renderSuccess();
    }

    public function submit()
    {
        $setting = Setting::getInstance('app.location')->fetch();
        $origin  = base_path('h5');
        $target  = base_path('public/h5');
        File::deleteDirectory($target);
        File::copyDirectory($origin, $target);

        if (File::isDirectory($target)) {
            $filepath = $target . '/index.html';
            $content  = File::get($filepath);
            $content  = str_replace('{{WEITAIR_TIME}}', time(), $content);
            File::put($filepath, $content);

            $root = Str::lower(config('app.url'));
            $dir  = File::allFiles($target . '/static/js');

            foreach ($dir as $file) {
                $filename = $file->getBasename();
                $secret   = File::get(base_path('secret.key'));
                if (Str::startsWith($filename, 'index')) {
                    $realpath = $file->getRealPath();
                    $content  = File::get($realpath);
                    $content  = str_replace('{{WEITAIR_ROOT}}', $root, $content);
                    $content  = str_replace('{{WEITAIR_SECRET}}', $secret, $content);
                    $content  = str_replace('{{WEITAIR_MAP}}', $setting['key'], $content);
                    File::put($realpath, $content);
                }
            }
        }
        $this->renderSuccess();
    }
}
