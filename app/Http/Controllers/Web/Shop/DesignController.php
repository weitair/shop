<?php

namespace App\Http\Controllers\Web\Shop;

use App\Http\Controllers\Web\Controller;
use App\Models\GoodsCategory;
use App\Models\GoodsGroup;
use App\Logics\Web\Page;
use App\Models\Setting;
use App\Models\Addon;
use App\Models\Link;
use App\Helper\Tree;

class DesignController extends Controller
{
    /**
     * 首页装修
     */
    public function home()
    {
        $this->renderSuccess(Page::getHome());
    }

    public function homeSubmit()
    {
        $this->validate([
            'header' => 'required|string',
            'params' => 'required|string',
        ]);

        $params = $this->request->post('params');
        $header = $this->request->post('header');

        if (Page::saveHome($header, $params)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function tabbar()
    {
        $this->renderSuccess(
            Setting::getInstance('design.tabbar')->fetch()
        );
    }

    public function tabbarSubmit()
    {
        $this->validate([
            'params' => 'required|string',
        ]);

        $result = Setting::getInstance('design.tabbar')
            ->submit($this->request->post('params'));

        if ($result) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function category()
    {
        $this->renderSuccess(
            Setting::getInstance('design.category')->fetch()
        );
    }

    public function categorySubmit()
    {
        $this->validate([
            'params' => 'required|string',
        ]);

        $result = Setting::getInstance('design.category')
            ->submit($this->request->post('params'));

        if ($result) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function mine()
    {
        $this->renderSuccess(
            Setting::getInstance('design.mine')->fetch()
        );
    }

    public function mineSubmit()
    {
        $this->validate([
            'params' => 'required|string',
        ]);

        $result = Setting::getInstance('design.mine')
            ->submit($this->request->post('params'));

        if ($result) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function cart()
    {
        $this->renderSuccess(
            Setting::getInstance('design.cart')->fetch()
        );
    }

    public function cartSubmit()
    {
        $this->validate([
            'params' => 'required|string',
        ]);

        $result = Setting::getInstance('design.cart')
            ->submit($this->request->post('params'));

        if ($result) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    /**
     * 用于diy中
     */
    public function goodsCategory()
    {
        $list = GoodsCategory::orderBy('sort', 'asc')->get();

        $this->renderSuccess(
            Tree::make($list)
        );
    }

    public function goodsGroup()
    {
        $this->renderSuccess( GoodsGroup::orderBy('sort', 'asc')->get() );
    }
}
