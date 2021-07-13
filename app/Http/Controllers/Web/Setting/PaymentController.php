<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\PaymentChannel;
use App\Models\Setting;

class PaymentController extends Controller
{
    public function list()
    {
        $this->renderSuccess(PaymentChannel::getList());
    }

    public function config()
    {
        $this->renderSuccess(
            Setting::getInstance('payment.wechat')->fetch()
        );
    }

    public function configSubmit()
    {
        $this->validate([
            'values' => 'required|string',
        ]);

        if (Setting::getInstance('payment.wechat')
            ->submit($this->request->post('values'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
