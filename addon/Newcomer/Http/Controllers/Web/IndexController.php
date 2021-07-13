<?php

namespace Addon\Newcomer\Http\Controllers\Web;

use App\Http\Controllers\Web\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->renderSuccess('新人数据');
    }
}
