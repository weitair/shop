<?php

namespace App\Http\Controllers\Web\Goods;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\GoodsGroup;

class GroupController extends Controller
{
    public function list()
    {
        $this->renderSuccess(
            GoodsGroup::getList()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => GoodsGroup::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'group_name' => 'required|string',
            'sort'       => 'required|int',
            'status'     => 'required|int',
        ]);

        if (GoodsGroup::add($this->request->all())) {
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
            GoodsGroup::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'         => 'required|int',
            'group_name' => 'required|string',
            'sort'       => 'required|int',
            'status'     => 'required|int',
        ]);

        if (GoodsGroup::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsGroup::status($this->request->get('id'))) {
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
        if (GoodsGroup::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (GoodsGroup::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
