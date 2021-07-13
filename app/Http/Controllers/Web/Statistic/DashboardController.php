<?php

namespace App\Http\Controllers\Web\Statistic;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\StatisticDashboard;

class DashboardController extends Controller
{
    /**
     * 运营数据
     */
    public function operations()
    {
        $date     = $this->request->get('date', 0);
        $uv       = StatisticDashboard::uv($date);
        $order    = StatisticDashboard::order($date);
        $percent  = conversion_rate($uv['current'], $order['current']); // 转化率
        $result[] = [
            'uv'      => $uv,
            'order'   => $order,
            'percent' => $percent
        ];

        $paymentSum     = StatisticDashboard::paymentSum($date);
        $paymentCount   = StatisticDashboard::paymentCount($date);
        $percentCurrent = $paymentCount['current'] === 0
            ? 0 : bcdiv($paymentSum['current'], $paymentCount['current'], 2);
        $percentBefore  = $paymentCount['before'] === 0
            ? 0 : bcdiv($paymentSum['before'], $paymentCount['before'], 2);
        $percentage     = yoy($percentCurrent, $percentBefore);
        $unitPrice = [
            'current' => $percentCurrent,
            'before'  => $percentBefore,
            'percent' => $percentage
        ];
        $result[] = [
            'amount'     => $paymentSum,
            'member'     => $paymentCount,
            'unit_price' => $unitPrice
        ];

        //
        $new = StatisticDashboard::memberNew($date);
        $old = StatisticDashboard::memberOld($date);
        $result[] = [
            'new' => $new,
            'old' => $old
        ];
        $this->renderSuccess($result);
    }

    /**
     * 商品销量排行
     */
    public function goods()
    {
        $this->renderSuccess(
            StatisticDashboard::goodsTop($this->request->get('date', 0))
        );
    }

    /**
     * 卡片数据
     */
    public function card()
    {
        $this->renderSuccess(
            StatisticDashboard::card()
        );
    }

    public function todo()
    {
        $this->renderSuccess(
            StatisticDashboard::todo()
        );
    }
}
