<?php

namespace App\Http\Controllers\Web\Channel\Weapp;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\MessageTemplate;

class SubscribeController extends Controller
{
    public function list()
    {
        $this->renderSuccess(MessageTemplate::getWeappList());
    }

    public function syncSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (MessageTemplate::getTemplate($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
