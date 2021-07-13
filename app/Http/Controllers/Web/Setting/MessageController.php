<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\MessageTemplate;
use App\Models\Setting;

class MessageController extends Controller
{
    public function index()
    {
        $this->validate([
            'key' => 'required|string',
        ]);

        $this->renderSuccess(
            Setting::getInstance('message.' . $this->request->get('key'))->fetch()
        );
    }

    public function submit()
    {
        $this->validate([
            'key'    => 'required|string',
            'values' => 'required|string',
        ]);

        if (Setting::getInstance('message.' . $this->request->post('key'))
            ->submit($this->request->post('values'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function template()
    {
        $this->renderSuccess(MessageTemplate::getList());
    }

    public function templateEdit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            MessageTemplate::detail($this->request->get('id'))
        );
    }

    public function templateEditSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (MessageTemplate::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
