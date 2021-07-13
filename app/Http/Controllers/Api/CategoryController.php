<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\GoodsCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            GoodsCategory::getList()
        );
    }

    public function goods()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            GoodsCategory::getGoodsList($this->request->get('id'))
        );
    }
}
