<?php

namespace App\Http\Controllers\Web\Channel\Weapp;

use App\Http\Controllers\Web\Controller;
use App\Models\Setting;
use File;
use Log;
use Str;

class ReleaseController extends Controller
{
    public function index()
    {
        $weapp_setting   = Setting::getInstance('wechat.weapp')->fetch();
        $payment_setting = Setting::getInstance('payment.wechat')->fetch();
        $result          = [
            'weapp'   => false,
            'payment' => false,
        ];

        if (!empty($weapp_setting) && !empty($weapp_setting['app_id']) && !empty($weapp_setting['app_secret'])) {
            $result['weapp'] = true;
        }
        if (!empty($payment_setting) && !empty($payment_setting['mch_id']) && !empty($payment_setting['mch_key'])) {
            $result['payment'] = true;
        }
        $this->renderSuccess($result);
    }

    public function download()
    {
        try {
            if ($this->createTemp()) {
                $path          = base_path('temp');
                $project_path  = $path . '/project.config.json';
                $vendor_path   = $path . '/common/vendor.js';
                $setting = Setting::getInstance('wechat.weapp')->fetch();

                if (File::exists($project_path) && File::exists($vendor_path)) {
                    $content = File::get($project_path);
                    $content = str_replace('{{WEITAIR_APPID}}', $setting['app_id'], $content);
                    File::put($project_path, $content);

                    $root = Str::lower(config('app.url'));
                    if (!Str::startsWith($root, 'https')) {
                        $root = Str::replaceFirst('http', 'https', $root);
                    }

                    $secret  = File::get(base_path('secret.key'));
                    $content = File::get($vendor_path);
                    $content = str_replace('{{WEITAIR_ROOT}}', $root, $content);
                    $content = str_replace('{{WEITAIR_SECRET}}', $secret, $content);
                    File::put($vendor_path, $content);
                }

                // 开始打包
                $zip     = new \ZipArchive();
                $zipname = 'weitair_' . date('Ymd') . '.zip';
                $result  = $zip->open($zipname, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

                if ($result) {
                    $files = File::allFiles(base_path('temp'));
                    foreach ($files as $item) {
                        $zip->addFile($item->getRealPath(), $item->getRelativePathname());
                    }
                }
                $zip->close();
                header("Content-Type: application/zip");
                header("Content-Transfer-Encoding: Binary");
                header("Content-Length: " . filesize($zipname));
                header("Content-Disposition: attachment; filename=\"" . basename($zipname) . "\"");
                readfile($zipname);
                @unlink($zipname);
                File::deleteDirectory(base_path('temp'));
//                return Storage::download('file.jpg', $name, $headers);
                exit;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    private function createTemp()
    {
        $temp_path   = base_path('temp');
        $wechat_path = base_path('wechat');

        if (!File::isDirectory($temp_path)) {
            File::makeDirectory($temp_path, 0775);
        }
        return File::copyDirectory($wechat_path, $temp_path);
    }
}
