<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Member;
use App\Logics\Api\Order;

class MineController extends Controller
{
    public function index()
    {
        $member = Member::detail();

        $result['member']             = $member;
        $result['member']['level']    = $member->level;
        $result['member']['favorite'] = $member->favorite()->count();
        $result['member']['history']  = $member->history()->count();
        $result['member']['coupon']   = $member->coupon()->where('expire_time', '>=', time())->count();

        $result['order']['created']  = $member->order()->where('order_status', Order::ORDER_STATUS_CREATED)->count();
        $result['order']['paid']     = $member->order()->where('order_status', Order::ORDER_STATUS_PAID)->count();
        $result['order']['shipped']  = $member->order()->where('order_status', Order::ORDER_STATUS_SHIPPED)->count();
        $result['order']['finished'] = $member->order()->where('order_status', Order::ORDER_STATUS_FINISHED)
            ->where('comment_status', Order::COMMENT_STATUS_UN)->count();
        $result['order']['service']  = 1;
        $this->renderSuccess($result);
    }
}
