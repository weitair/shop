<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use App\Logics\Api\Page;

class PageController extends Controller
{
    public function index()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Page::detail($this->request->get('id'))
        );
    }

    public function home()
    {
        $this->renderSuccess(Page::home());
    }

    public function cart()
    {
        $design = Setting::getInstance('design.cart')->fetch();
        $this->renderSuccess(Page::getResult($design ? $design : []));
    }

    public function mine()
    {
        $design = Setting::getInstance('design.mine')->fetch();
        $this->renderSuccess(Page::getResult($design ? $design : []));
    }
}
