<?php

namespace Addon\Coupon\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Addon\Coupon\Logics\Web\Coupon;
use App\Logics\Web\MemberTag;

class CouponController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Coupon::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'tag' => MemberTag::getAll()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'coupon_name'    => 'required|string',
            'coupon_visible' => 'required|int',
            'total'          => 'required|int',
            'receive_limit'  => 'required|int',
            'goods_limit'    => 'required|int',
            'tag_limit'      => 'required|int',
            'coupon_type'    => 'required|int',
            'discount'       => 'required|numeric',
            'discount_limit' => 'required|numeric',
            'amount'         => 'required|numeric',
            'condition'      => 'required|numeric',
            'expire_type'    => 'required|int',
            'effective_time' => 'required|int',
            'goods'          => 'array',
            'tag'            => 'array',
            'begin_time'     => 'string',
            'end_time'       => 'string',
        ]);

        if (Coupon::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'tag'    => MemberTag::getAll(),
            'detail' => Coupon::detail($this->request->get('id'))
        ]);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'             => 'required|int',
            'coupon_name'    => 'required|string',
            'coupon_visible' => 'required|int',
            'total'          => 'required|int',
            'receive_limit'  => 'required|int',
            'goods_limit'    => 'required|int',
            'tag_limit'      => 'required|int',
            'coupon_type'    => 'required|int',
            'discount'       => 'required|numeric',
            'discount_limit' => 'required|numeric',
            'amount'         => 'required|numeric',
            'condition'      => 'required|numeric',
            'expire_type'    => 'required|int',
            'effective_time' => 'required|int',
            'goods'          => 'array',
            'tag'            => 'array',
            'begin_time'     => 'string',
            'end_time'       => 'string',
        ]);

        if (Coupon::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function push()
    {
        $this->renderSuccess([
            'tag' => MemberTag::getAll()
        ]);
    }

    public function pushSubmit()
    {
        $this->validate([
            'coupon_name'    => 'required|string',
            'group'          => 'required|int',
            'coupon_type'    => 'required|int',
            'discount'       => 'required|numeric',
            'discount_limit' => 'required|numeric',
            'amount'         => 'required|numeric',
            'condition'      => 'required|numeric',
            'expire_type'    => 'required|int',
            'effective_time' => 'required|int',
            'begin_time'     => 'string',
            'end_time'       => 'string',
            'member'         => 'array',
            'tag'            => 'array',
        ]);

        if (Coupon::pushSubmit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int'
        ]);

        if (Coupon::status($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Coupon::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
