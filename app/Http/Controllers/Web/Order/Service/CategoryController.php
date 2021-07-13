<?php

namespace App\Http\Controllers\Web\Order\Service;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\ServiceCategory;

class CategoryController extends Controller
{
    public function list()
    {
        $this->renderSuccess(ServiceCategory::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => ServiceCategory::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort'          => 'required|int',
            'status'        => 'required|int',
        ]);

        if (ServiceCategory::add($this->request->all())) {
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
            ServiceCategory::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'            => 'required|int',
            'category_name' => 'required|string',
            'sort'          => 'required|int',
            'status'        => 'required|int',
        ]);

        if (ServiceCategory::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (ServiceCategory::status($this->request->get('id'))) {
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
        if (ServiceCategory::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (ServiceCategory::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
