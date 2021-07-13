<?php

namespace App\Http\Controllers\Web\Goods;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\GoodsCategory;

class CategoryController extends Controller
{
    public function list()
    {
        $this->renderSuccess(
            GoodsCategory::getList()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'parent' => GoodsCategory::getFormList(),
            'sort'   => GoodsCategory::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort'          => 'required|int',
            'status'        => 'required|int',
        ]);
        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (GoodsCategory::add($data)) {
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
        $data['detail'] = GoodsCategory::detail($id);
        $data['parent'] = GoodsCategory::getFormList($id);
        $this->renderSuccess($data);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'            => 'required|int',
            'category_name' => 'required|string',
            'sort'          => 'required|int',
            'status'        => 'required|int',
        ]);

        $data = $this->request->all();
        $data['parent_id'] = $data['parent_id'] ?? 0;

        if (GoodsCategory::edit($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsCategory::status($this->request->get('id'))) {
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
        if (GoodsCategory::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (GoodsCategory::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
