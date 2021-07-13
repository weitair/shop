<?php

namespace App\Http\Controllers\Web\Goods;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\GoodsSupport;

class SupportController extends Controller
{
    public function list()
    {
        $this->renderSuccess(GoodsSupport::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => GoodsSupport::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'support_name' => 'required|string',
            'content'      => 'required|string',
            'sort'         => 'required|int',
        ]);

        if (GoodsSupport::add($this->request->all())) {
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
            GoodsSupport::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'           => 'required|int',
            'support_name' => 'required|string',
            'content'      => 'required|string',
            'sort'         => 'required|int',
        ]);

        if (GoodsSupport::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsSupport::status($this->request->get('id'))) {
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
        if (GoodsSupport::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (GoodsSupport::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
