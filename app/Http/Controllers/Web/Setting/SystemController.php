<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Web\Controller;
use App\Models\Setting;
use Cache;

class SystemController extends Controller
{
    public function index()
    {
        $this->validate([
            'key' => 'required|string',
        ]);

        $this->renderSuccess(
            Setting::getInstance('system.' . $this->request->get('key'))->fetch()
        );
    }

    public function submit()
    {
        $this->validate([
            'key'    => 'required|string',
            'values' => 'required|string',
        ]);

        if (Setting::getInstance('system.' . $this->request->post('key'))
            ->submit($this->request->post('values'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function cacheSubmit()
    {
        $this->validate([
            'key' => 'required|string',
        ]);

        switch ($this->request->post('key')) {
            case 'business':
                Cache::flush();
                break;
            case 'system':
                Cache::store('file')->flush();
                break;
        }
        $this->renderSuccess([], '操作成功');
    }
}
