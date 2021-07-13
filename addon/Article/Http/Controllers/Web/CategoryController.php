<?php

namespace Addon\Article\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Addon\Article\Logics\Web\ArticleCategory;

class CategoryController extends Controller
{
    public function list()
    {
        $this->renderSuccess(ArticleCategory::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => ArticleCategory::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort'          => 'required|int',
        ]);

        if (ArticleCategory::add($this->request->all())) {
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
            ArticleCategory::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'            => 'required|int',
            'category_name' => 'required|string',
            'sort'          => 'required|int',
        ]);

        if (ArticleCategory::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (ArticleCategory::status($this->request->get('id'))) {
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
        if (ArticleCategory::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (ArticleCategory::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
