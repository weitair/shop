<?php

namespace App\Http\Controllers\Web\Statistic;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StatisticFinance;

class FinanceController extends Controller
{
    public function global()
    {
        $this->renderSuccess(
            StatisticFinance::global($this->request->get('type', 0))
        );
    }

    public function card()
    {
        $this->renderSuccess(
            StatisticFinance::card()
        );
    }
}
