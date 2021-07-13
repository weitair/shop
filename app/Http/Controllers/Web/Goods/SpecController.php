<?php

namespace App\Http\Controllers\Web\Goods;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Spec;

class SpecController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Spec::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Spec::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Spec::add($this->request->all())) {
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
            Spec::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'   => 'required|int',
            'name' => 'required|string',
            'sort' => 'required|int',
        ]);

        if (Spec::edit($this->request->all())) {
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
        if (Spec::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Spec::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function addValueSubmit()
    {
        $this->validate([
            'spec_id' => 'required|int',
            'name'    => 'required|string',
        ]);

        if ($model = Spec::addValue($this->request->all())) {
            $this->renderSuccess(['id' => $model->id], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeValueSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Spec::removeValue($this->request->post('id')) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
