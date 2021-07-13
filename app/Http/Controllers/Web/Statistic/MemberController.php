<?php

namespace App\Http\Controllers\Web\Statistic;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StatisticMember;

class MemberController extends Controller
{
    public function global()
    {
        $this->renderSuccess(
            StatisticMember::global($this->request->get('type', 0))
        );
    }

    public function channel()
    {
        $this->renderSuccess(
            StatisticMember::channel()
        );
    }

    public function province()
    {
        $this->renderSuccess(
            StatisticMember::province()
        );
    }
}
