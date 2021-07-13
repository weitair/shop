<?php

namespace Addon\Coupon\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Addon\Coupon\Logics\Api\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Coupon::getList()
        );
    }

    /**
     * 领取优惠卷
     */
    public function receive()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Coupon::received($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    /**
     * 我的优惠卷
     */
    public function mine()
    {
        $this->validate([
            'status' => 'required|int',
        ]);

        $this->renderSuccess(
            Coupon::mineList()
        );
    }
}
