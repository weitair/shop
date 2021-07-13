<?php

namespace Addon\Article\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;
use Addon\Article\Logics\Web\Article;
use Addon\Article\Logics\Web\ArticleCategory;

class ArticleController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Article::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'category' => ArticleCategory::getAll()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'category_id' => 'required|int',
            'image'       => 'required|string',
            'title'       => 'required|string',
        ]);

        if (Article::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $data['detail'] = Article::detail($this->request->get('id'));
        $data['category'] = ArticleCategory::getAll();
        $this->renderSuccess($data);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'          => 'required|int',
            'category_id' => 'required|int',
            'image'       => 'required|string',
            'title'       => 'required|string',
        ]);

        if (Article::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Article::status($this->request->get('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Article::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
