<?php

namespace Addon\Article\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Addon\Article\Logics\Web\ArticleBanner;

class BannerController extends Controller
{
    public function list()
    {
        $this->renderSuccess(
            ArticleBanner::getList()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => ArticleBanner::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'image' => 'required|string',
            'sort'  => 'required|int',
        ]);

        if (ArticleBanner::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->renderSuccess(
            ArticleBanner::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'    => 'required|int',
            'image' => 'required|string',
            'sort'  => 'int',
        ]);

        if (ArticleBanner::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (ArticleBanner::status($this->request->get('id'))) {
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
        if (ArticleBanner::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (ArticleBanner::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
