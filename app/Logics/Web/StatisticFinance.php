<?php

namespace App\Logics\Web;

use App\Helper\Date;
use DB;

class StatisticFinance
{
    public static function global(int $type)
    {
        $result   = [];
        $length   = $type ? 30 : 7;
        $legend['data'] = [
            '支付金额',
            '未支付金额',
            '支付用户数',
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
                        $series[$key]['data'][] = Payment::where('status', Payment::STATUS_PAID)
                            ->whereBetween('payment_time', [$between['start'], $between['end']])
                            ->sum('payment_price') / 100;
                        break;
                    case 1:
                        $series[$key]['data'][] = Payment::where('status', Payment::STATUS_UNPAID)
                            ->whereBetween('payment_time', [$between['start'], $between['end']])
                            ->sum('payment_price') / 100;
                        break;
                    case 2:
                        $series[$key]['data'][] = Payment::whereBetween('payment_time',[$between['start'], $between['end']])
                            ->count(DB::raw('DISTINCT(member_id)'));
                        break;
                }
            }
        }
        $result['legend'] = $legend;
        $result['series'] = $series;
        return $result;
    }

    public static function card()
    {
        $result['paid']   = Payment::where('status', Payment::STATUS_PAID)->sum('payment_price') / 100;
        $result['unpaid'] = Payment::where('status', Payment::STATUS_UNPAID)->sum('payment_price') / 100;
        $result['order']  = Payment::count(DB::raw('DISTINCT(order_id)'));
        $result['member'] = Payment::count(DB::raw('DISTINCT(member_id)'));
        return $result;
    }
}
