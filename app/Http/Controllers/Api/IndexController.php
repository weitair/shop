<?php

namespace App\Http\Controllers\Api;

use Nwidart\Modules\Facades\Module;
use App\Services\Wechat\Factory;
use App\Events\App\EntryEvent;
use App\Models\Setting;
use Event;
use Log;

class IndexController extends Controller
{
    /**
     * 用户进入 App
     */
    public function index()
    {
        Event::dispatch(new EntryEvent());

        $result['app']         = Setting::getInstance('app.base')->fetch();
        $result['tabbar']      = Setting::getInstance('design.tabbar')->fetch();
        $result['category']    = Setting::getInstance('design.category')->fetch();
        $result['wechat']      = [];

        try {
            if ($this->request->get('wechat') == 'true') {
                $wechat = Factory::getInstance('base');
                $wechat->app->jssdk->setUrl(config('app.url') . '/h5/');
                $result['wechat'] = json_decode(
                    $wechat->app->jssdk->buildConfig([
                        'chooseWXPay',
                        'openLocation',
                        'getLocation'
                    ])
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
        $this->renderSuccess($result);
    }

    /**
     * 关于我们
     */
    public function about()
    {
        $setting = Setting::getInstance('app.about')->fetch();
        $this->renderSuccess($setting);
    }

    public function popupwindow()
    {
        $result = null;
        if (Module::has('Popupwindow')) {
            if ($result = \Addon\Popupwindow\Logics\Api\PopupWindow::fetch()) {
                $result->increment('open');
            }
        }
        $this->renderSuccess($result);
    }
}
