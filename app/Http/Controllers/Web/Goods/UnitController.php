<?php

namespace App\Http\Controllers\Web\Goods;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Unit;

class UnitController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Unit::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Unit::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'unit_name' => 'required|string',
            'sort'      => 'required|int',
        ]);

        if (Unit::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        $this->renderSuccess(
            Unit::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'        => 'required|int',
            'unit_name' => 'required|string',
            'sort'      => 'required|int',
        ]);

        if (Unit::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sortSubmit()
    {
        $this->validate([
            'id' => 'required|int',
            'value' => 'required|int',
        ]);

        $id    = $this->request->get('id');
        $value = $this->request->get('value');
        if (Unit::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Unit::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
