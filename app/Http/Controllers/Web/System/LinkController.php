<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Link;

class LinkController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Link::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'parent' => Link::getFormList(),
            'sort'   => Link::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Link::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id'         => 'required|int',
        ]);

        $id = $this->request->get('id');
        $data['detail'] = Link::detail($id);
        $data['parent'] = Link::getFormList($id);
        $this->renderSuccess($data);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'   => 'required|int',
            'name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Link::edit($this->request->all())) {
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
        if (Link::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Link::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
