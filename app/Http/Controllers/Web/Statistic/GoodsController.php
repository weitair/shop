<?php

namespace App\Http\Controllers\Web\Statistic;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StatisticGoods;

class GoodsController extends Controller
{
    public function card()
    {
        $this->renderSuccess(
            StatisticGoods::card()
        );
    }

    public function view()
    {
        $this->renderSuccess(
            StatisticGoods::view()
        );
    }

    public function sale()
    {
        $this->renderSuccess(
            StatisticGoods::sale()
        );
    }

    public function payment()
    {
        $this->renderSuccess(
            StatisticGoods::payment()
        );
    }
}
