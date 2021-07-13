<?php

namespace Addon\Install\Http\Controllers;

use App\Http\Controllers\Web\Controller;
use Addon\Install\Models\Install;
use File;
use Log;

class InstallController extends Controller
{
    public function index()
    {
        if (File::isFile(base_path('install.lock'))) {
            return redirect('/');
        }
        return view('install::step1');
    }

    public function step2()
    {
        return view('install::step2');
    }

    public function step3()
    {
        return view('install::step3');
    }

    public function step4()
    {
        return view('install::step4');
    }

    public function step5()
    {
        return view('install::step5');
    }

    public function detect ()
    {
        $base = [
            ['name' => '域名', 'value' => $_SERVER['SERVER_NAME']],
            ['name' => '操作系统', 'value' => PHP_OS],
            ['name' => 'PHP版本', 'value' => PHP_VERSION],
            ['name' => 'Web服务器', 'value' => $_SERVER['SERVER_SOFTWARE']],
            ['name' => '安装目录', 'value'  => dirname($_SERVER['DOCUMENT_ROOT'])],
        ];
        // php
        $php     = version_compare(PHP_VERSION, '7.2.0') == -1 ? false : true;
        $check[] = ['name' => 'php', 'value' => $php, 'intro' => '需 7.2 以上版本'];

        // mysql
        $mysql   = extension_loaded('pdo') && extension_loaded('pdo_mysql');
        $check[] = ['name' => 'mysql', 'value' => $mysql, 'intro' => '扩展未打开'];

        // redis
        $redis   = extension_loaded('redis');
        $check[] = ['name' => 'redis', 'value' => $redis, 'intro' => '扩展未打开'];

        // openssl
        $openssl = extension_loaded('openssl');
        $check[] = ['name' => 'openssl', 'value' => $openssl, 'intro' => '扩展未打开'];

        //gd
        $gd      = extension_loaded('gd');
        $check[] = ['name' => 'gd', 'value' => $gd, 'intro' => '不能生成分享图片'];

        // imagick
        $imagick = extension_loaded('imagick');
        $check[] = ['name' => 'imagick', 'value' => $imagick, 'intro' => 'H5端不能生成分享图片'];

        // fileinfo
        $fileinfo = extension_loaded('fileinfo');
        $check[]  = ['name' => 'fileinfo', 'value' => $fileinfo, 'intro' => '扩展未打开'];

        // zip
        $zip     = extension_loaded('zip');
        $check[] = ['name' => 'zip', 'value' => $zip, 'intro' => '扩展未打开'];

        // curl
        $curl    = extension_loaded('curl');
        $check[] = ['name' => 'curl', 'value' => $curl, 'intro' => '扩展未打开'];

        $path   = base_path();
        $status = File::isWritable($path);
        $dir[]  = ['name' => '/', 'value' => $status, 'intro' => '不可写'];

        $path   = base_path('public');
        $status = File::isWritable($path);
        $dir[]  = ['name' => '/public', 'value' => $status, 'intro' => '不可写'];

        $path   = base_path('storage');
        $status = File::isWritable($path);
        $dir[]  = ['name' => '/storage', 'value' => $status, 'intro' => '不可写'];

        if ($php && $mysql && $openssl && $fileinfo && $zip && $curl) {
            $pass = true;
        } else {
            $pass = false;
        }
        $this->renderSuccess(compact('base', 'check', 'dir', 'pass'));
    }

    public function test()
    {
        $this->validate([
            'dbhost'     => 'required|string',
            'dbport'     => 'required|string',
            'dbuser'     => 'required|string',
            'dbpassword' => 'required|string',
        ]);

        try {
            $params  = $this->request->post();
            $connect = mysqli_connect(
                $params['dbhost'],
                $params['dbuser'],
                $params['dbpassword'],
                '',
                $params['dbport']
            );

            if ($connect) {
                $this->renderSuccess();
            }
            $this->renderError();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            $this->renderError();
        }
    }

    public function check()
    {
        try {
            $params  = $this->request->post();
            $connect = mysqli_connect($params['dbhost'], $params['dbuser'], $params['dbpassword'], "", $params['dbport']);

            if (!mysqli_select_db($connect, $params['dbname'])) {
                $this->renderSuccess();
            }
            $this->renderError();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            $this->renderError();
        }
    }

    public function submit()
    {
        if (Install::submit($this->request->post())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
