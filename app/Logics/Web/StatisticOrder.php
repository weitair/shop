<?php

namespace App\Logics\Web;

use App\Helper\Date;
use DB;

class StatisticOrder
{
    public static function card()
    {
        $result['all']      = Order::count();
        $result['created']  = Order::where('order_status', Order::ORDER_STATUS_CREATED)->count();
        $result['paid']     = Order::where('order_status', Order::ORDER_STATUS_PAID)->count();
        $result['shipped']  = Order::where('order_status', Order::ORDER_STATUS_SHIPPED)->count();
        $result['finished'] = Order::where('order_status', Order::ORDER_STATUS_FINISHED)->count();
        $result['closed']   = Order::where('order_status', Order::ORDER_STATUS_CLOSED)->count();
        return $result;
    }

    public static function global(int $type)
    {
        $result   = [];
        $length   = $type ? 30 : 7;
        $legend['data'] = [
            '支付总金额',
            '支付订单数',
            '优惠总金额',
            '下单客户数',
            '客单价',
        ];

        for ($i = $length; $i > 0; $i--) {
            $array  = Date::beforeDay($i - 1);
            $data[] = $array;
            $result['xAxis']['data'][] = date("m-d", $array['start']);
        }

        foreach ($legend['data'] as $key => $name) {
            foreach ($data as $between) {
                $series[$key]['name']   = $name;
                $series[$key]['type']   = 'line';
                $series[$key]['smooth'] = true;

                switch ($key) {
                    case 0:
                        $series[$key]['data'][] = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                            ->whereBetween('order_time',[$between['start'], $between['end']])
                            ->sum('payment_price') / 100;
                        break;
                    case 1:
                        $series[$key]['data'][] = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                                ->whereBetween('order_time',[$between['start'], $between['end']])
                                ->count();
                        break;
                    case 2:
                        $series[$key]['data'][] = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                            ->whereBetween('order_time',[$between['start'], $between['end']])
                            ->sum('coupon_price') / 100;
                        break;
                    case 3:
                        $series[$key]['data'][] = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                            ->whereBetween('order_time',[$between['start'], $between['end']])
                            ->count(DB::raw('DISTINCT(member_id)'));
                        break;
                    case 4:
                        $sum = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                            ->whereBetween('order_time',[$between['start'], $between['end']])
                            ->sum('payment_price');

                        $member = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                            ->whereBetween('order_time',[$between['start'], $between['end']])
                            ->count(DB::raw('DISTINCT(member_id)'));

                        if ($sum) {
                            $amount = round($sum / $member, 2);
                            $series[$key]['data'][] = round($amount / 100, 2);
                        } else {
                            $series[$key]['data'][] = 0;
                        }
                        break;
                }
            }
        }
        $result['legend'] = $legend;
        $result['series'] = $series;
        return $result;
    }
}
