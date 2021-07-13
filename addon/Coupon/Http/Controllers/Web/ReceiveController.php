<?php

namespace Addon\Coupon\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Addon\Coupon\Logics\Web\CouponReceive;

class ReceiveController extends Controller
{
    public function list()
    {
        $this->renderSuccess(CouponReceive::getList());
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (CouponReceive::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
