<?php

namespace App\Http\Controllers\Web\System\Assets;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\AssetsGroup;

class GroupController extends Controller
{
    public function list()
    {
        $this->renderSuccess(AssetsGroup::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => AssetsGroup::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'group_name' => 'required|string',
            'sort'       => 'required|int',
        ]);

        if (AssetsGroup::add($this->request->all())) {
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
            AssetsGroup::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'         => 'required|int',
            'group_name' => 'required|string',
            'sort'       => 'required|int',
        ]);

        if (AssetsGroup::edit($this->request->all())) {
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
        if (AssetsGroup::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (AssetsGroup::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
