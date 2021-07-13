<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Express;

class ExpressController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Express::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Express::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'company' => 'required|string',
            'code'    => 'required|string',
            'sort'    => 'required|int',
        ]);

        if (Express::add($this->request->all())) {
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
            Express::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'      => 'required|int',
            'company' => 'required|string',
            'code'    => 'required|string',
            'sort'    => 'required|int',
        ]);

        if (Express::edit($this->request->all())) {
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
        if (Express::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Express::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
