<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Cart;

class CartController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'list'    => Cart::getList(),
            'failure' => Cart::getFailureList(),
            'count'   => Cart::getCount()
        ]);
    }

    /**
     * 获取购物车商品总数
     */
    public function count()
    {
        $this->renderSuccess(
            Cart::getCount()
        );
    }

    public function add()
    {
        $this->validate([
            'goods_id'     => 'required|int',
            'goods_name'   => 'required|string',
            'image'        => 'required|string',
            'goods_sku_id' => 'required|int',
            'sales_price'  => 'required|numeric',
            'quantity'     => 'required|int',
        ]);

        if (Cart::add($this->request->all())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    /**
     * 改变数量
     * @throws \App\Exceptions\AppException
     */
    public function change()
    {
        $this->validate([
            'id'       => 'required|int',
            'quantity' => 'required|int',
        ]);

        if (Cart::change($this->request->all())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    /**
     * 清除失效商品
     */
    public function clear()
    {
        if (Cart::clear()) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    /**
     * 删除购物车中商品
     */
    public function remove()
    {
        $this->validate([
            'id' => 'required|array',
        ]);

        if (Cart::remove($this->request->post('id')) === true) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
