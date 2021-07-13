<?php

namespace App\Http\Controllers\Web\Shop;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StoreEmployee;

class EmployeeController extends Controller
{
    public function list()
    {
        $this->renderSuccess(StoreEmployee::getList());
    }

    public function add()
    {
        $this->renderSuccess();
    }

    public function addSubmit()
    {
        $this->validate([
            'member_id' => 'required|int',
            'name'      => 'required|string',
            'phone'     => 'required|string',
        ]);

        if (StoreEmployee::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            StoreEmployee::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'        => 'required|int',
            'member_id' => 'required|int',
            'name'      => 'required|string',
            'phone'     => 'required|string',
        ]);

        if (StoreEmployee::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (StoreEmployee::status($this->request->get('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        if (StoreEmployee::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
