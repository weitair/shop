<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\OrderVerify;

class VerifyController extends Controller
{
    public function index()
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
