<?php

namespace App\Http\Controllers\Web\Shop;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Page;

class PageController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Page::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Page::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'title' => 'required|string',
        ]);

        if (Page::add($this->request->all())) {
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
            Page::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'    => 'required|int',
            'title' => 'required|string',
        ]);

        if (Page::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Page::status($this->request->get('id'))) {
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
        if (Page::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    /**
     * 设置为首页
     */
    public function homeSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Page::setHome($this->request->get('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Page::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
