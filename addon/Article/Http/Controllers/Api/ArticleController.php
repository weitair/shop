<?php

namespace Addon\Article\Http\Controllers\Api;

use App\Http\Controllers\Web\Controller;
use Addon\Article\Logics\Api\Article;
use Addon\Article\Logics\Api\ArticleBanner;
use Addon\Article\Logics\Api\ArticleCategory;

class ArticleController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'banner'   => ArticleBanner::getList(),
            'category' => ArticleCategory::getList(),
            'list'     => Article::getList()
        ]);
    }

    public function list()
    {
        $this->validate([
            'category' => 'required|int',
        ]);

        $this->renderSuccess(Article::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Article::detail($this->request->get('id'))
        );
    }
}
