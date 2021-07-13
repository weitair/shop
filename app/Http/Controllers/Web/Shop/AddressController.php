<?php

namespace App\Http\Controllers\Web\Shop;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StoreAddress;

class AddressController extends Controller
{
    public function list()
    {
        $this->renderSuccess(StoreAddress::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => StoreAddress::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'address_name'   => 'required|string',
            'phone'          => 'required|string',
            'business'       => 'required|int',
            'business_begin' => 'required|string',
            'business_end'   => 'required|string',
            'province'       => 'required|string',
            'city'           => 'required|string',
            'district'       => 'required|string',
            'lon'            => 'required|string',
            'lat'            => 'required|string',
            'detail'         => 'required|string',
            'status'         => 'required|int',
            'is_fetch'       => 'required|int',
            'is_shipment'    => 'required|int',
        ]);

        if (StoreAddress::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->renderSuccess(
            StoreAddress::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'             => 'required|int',
            'address_name'   => 'required|string',
            'phone'          => 'required|string',
            'business'       => 'required|int',
            'business_begin' => 'required|string',
            'business_end'   => 'required|string',
            'province'       => 'required|string',
            'city'           => 'required|string',
            'district'       => 'required|string',
            'lon'            => 'required|string',
            'lat'            => 'required|string',
            'detail'         => 'required|string',
            'status'         => 'required|int',
            'is_fetch'       => 'required|int',
            'is_shipment'    => 'required|int',
        ]);

        if (StoreAddress::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (StoreAddress::status($this->request->get('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sortSubmit()
    {
        $this->validate([
            'id'    => 'required|int',
            'value' => 'required|int',
        ]);

        $id = $this->request->get('id');
        $value = $this->request->get('value');
        if (StoreAddress::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        if (StoreAddress::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
