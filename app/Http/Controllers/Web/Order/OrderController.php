<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StoreEmployee;
use App\Logics\Web\Express;
use App\Logics\Web\Order;
use App\Models\OrderPackage;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;

class OrderController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Order::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Order::detail($this->request->get('id'))
        );
    }

    public function shipment()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'express'  => Express::getAll(),
            'employee' => StoreEmployee::deliveryList(),
            'detail'   => Order::detail($this->request->get('id'))
        ]);
    }

    public function shipmentSubmit()
    {
        $data = $this->request->all();

        if ($data['logistics_method'] == Order::LOGISTICS_METHOD_EXPRESS) {
            $this->validate([
                'order_id'   => 'required|int',
                'goods_id'   => 'required|array',
                'express_id' => 'required|int',
                'express_sn' => 'required|string',
            ]);
        }
        if ($data['logistics_method'] == Order::LOGISTICS_METHOD_LOCAL) {
            if ($data['channel'] == OrderPackage::CHANNEL_SELF) {
                $this->validate([
                    'order_id'    => 'required|int',
                    'employee_id' => 'required|int',
                ]);
            } else {
                $this->validate([
                    'order_id'    => 'required|int',
                    'delivery'    => 'required|string',
                    'phone'       => 'required|string',
                ]);
            }
        }

        if (Order::shipment($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function logistics()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Order::detail($this->request->get('id'))
        );
    }

    public function logisticsSubmit()
    {
        $this->validate([
            'order_id'   => 'required|int',
            'contact'    => 'required|string',
            'phone'      => 'required|string',
            'province'   => 'required|string',
            'city'       => 'required|string',
            'district'   => 'required|string',
            'detail'     => 'required|string',
        ]);

        if (Order::logistic($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function remark()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Order::detail($this->request->get('id'))
        );
    }

    public function remarkSubmit()
    {
        $this->validate([
            'id'     => 'required|int',
            'remark' => 'required|string',
        ]);

        if (Order::remark($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function price()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Order::detail($this->request->get('id'))
        );
    }

    public function priceSubmit()
    {
        $this->validate([
            'id'     => 'required|int',
            'change' => 'required|numeric',
        ]);

        if (Order::price($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function receiveSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Order::receive($this->request->get('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function printsSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Order::prints($this->request->get('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
