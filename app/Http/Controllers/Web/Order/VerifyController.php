<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\OrderVerify;

class VerifyController extends Controller
{
    public function list()
    {
        $this->renderSuccess(OrderVerify::getList());
    }

    public function search()
    {
        $this->validate([
            'code' => 'required|string',
        ]);

        $this->renderSuccess(
            OrderVerify::search($this->request->get('code'))
        );
    }

    public function submit()
    {
        $this->validate([
            'code' => 'required|string',
        ]);

        if (OrderVerify::submit($this->request->post('code'))) {
            $this->renderSuccess([], '核销成功');
        }
        $this->renderError([], '核销失败');
    }
}
