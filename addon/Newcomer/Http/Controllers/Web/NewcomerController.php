<?php

namespace Addon\Newcomer\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use App\Models\Setting;

class NewcomerController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Setting::getInstance('newcomer.base')->fetch()
        );
    }

    public function submit()
    {
        $this->validate([
            'values' => 'required|string',
        ]);

        if (Setting::getInstance('newcomer.base')
            ->submit($this->request->post('values'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
