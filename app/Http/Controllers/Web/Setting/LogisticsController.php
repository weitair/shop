<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Web\Controller;
use App\Models\Setting;

class LogisticsController extends Controller
{
    public function index()
    {
        $this->validate([
            'key' => 'required|string',
        ]);

        $this->renderSuccess(
            Setting::getInstance('logistics.' . $this->request->get('key'))->fetch()
        );
    }

    public function submit()
    {
        $this->validate([
            'key'    => 'required|string',
            'values' => 'required|string',
        ]);

        if (Setting::getInstance('logistics.' . $this->request->post('key'))
            ->submit($this->request->post('values'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
