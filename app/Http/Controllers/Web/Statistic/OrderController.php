<?php

namespace App\Http\Controllers\Web\Statistic;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StatisticOrder;

class OrderController extends Controller
{
    public function card()
    {
        $this->renderSuccess(
            StatisticOrder::card()
        );
    }

    public function global()
    {
        $this->renderSuccess(
            StatisticOrder::global($this->request->get('type', 0))
        );
    }
}
