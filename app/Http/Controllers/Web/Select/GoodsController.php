<?php

namespace App\Http\Controllers\Web\Select;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\GoodsCategory;
use App\Logics\Web\GoodsSupport;
use App\Logics\Web\GoodsGroup;
use App\Logics\Web\Select;

class GoodsController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'category' => GoodsCategory::getList(),
            'group'    => GoodsGroup::getAll(),
            'support'  => GoodsSupport::getAll(),
            'list'     => Select::goodsList(),
        ]);
    }

    public function list()
    {
        $this->renderSuccess(Select::goodsList());
    }
}
