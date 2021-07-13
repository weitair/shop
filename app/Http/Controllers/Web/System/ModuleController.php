<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Module;

class ModuleController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Module::getTree());
    }

    public function add()
    {
        $this->renderSuccess([
            'parent' => Module::getParentTree()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'module_name' => 'required|string',
            'type'        => 'required|int',
        ]);

        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (Module::add($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $id = $this->request->get('id');
        $data['detail'] = Module::detail($id);
        $data['parent'] = Module::getParentTree();
        $this->renderSuccess($data);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'          => 'required|int',
            'module_name' => 'required|string',
            'type'        => 'required|int',
        ]);

        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (Module::edit($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sort()
    {
        $this->renderSuccess(Module::getList());
    }

    public function sortSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Module::sort($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Module::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
