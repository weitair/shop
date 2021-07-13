<?php

namespace App\Helper;

use Carbon\Carbon;

class Date
{
    /**
     * 返回今日开始和结束时间戳
     * @return mixed
     */
    public static function today()
    {
        $result['start'] = Carbon::today()->startOfDay()->timestamp;
        $result['end']   = Carbon::today()->endOfDay()->timestamp;
        return $result;
    }

    /**
     * 返回昨日开始和结束时间戳
     * @return mixed
     */
    public static function yesterday()
    {
        $result['start'] = Carbon::yesterday()->startOfDay()->timestamp;
        $result['end']   = Carbon::yesterday()->endOfDay()->timestamp;
        return $result;
    }

    /**
     * 返回 N天之前开始和结束时间戳
     * @param int $num
     * @return mixed
     */
    public static function beforeDay(int $num)
    {
        $result['start'] = Carbon::now()->subDays($num)->startOfDay()->timestamp;
        $result['end']   = Carbon::now()->subDays($num)->endOfDay()->timestamp;
        return $result;
    }

    /**
     * 返回本周开始和结束时间戳
     * @return mixed
     */
    public static function week()
    {
        $result['start'] = Carbon::now()->startOfWeek()->timestamp;
        $result['end']   = Carbon::now()->endOfWeek()->timestamp;
        return $result;
    }

    /**
     * 返回 N 周之前开始和结束时间戳
     * @return mixed
     */
    public static function beforeWeek(int $num)
    {
        $result['start'] = Carbon::now()->subWeeks($num)->startOfWeek()->timestamp;
        $result['end']   = Carbon::now()->subWeeks($num)->endOfWeek()->timestamp;
        return $result;
    }

    /**
     * 返回本月开始和结束时间戳
     * @return mixed
     */
    public static function month()
    {
        $result['start'] = Carbon::now()->startOfMonth()->timestamp;
        $result['end']   = Carbon::now()->endOfMonth()->timestamp;
        return $result;
    }

    /**
     * 返回 N 月开始和结束时间戳
     * @return mixed
     */
    public static function beforeMonth(int $num)
    {
        $result['start'] = Carbon::now()->subMonths($num)->startOfMonth()->timestamp;
        $result['end']   = Carbon::now()->subMonths($num)->endOfMonth()->timestamp;
        return $result;
    }

    /**
     * 返回本年开始和结束时间戳
     * @return mixed
     */
    public static function year()
    {
        $result['start'] = Carbon::now()->startOfYear()->timestamp;
        $result['end']   = Carbon::now()->endOfYear()->timestamp;
        return $result;
    }

    /**
     * 返回本季度开始和结束时间戳
     * @return mixed
     */
    public static function quarter()
    {
        $result = [];
        $now    = Carbon::now();
        switch($now->month) {
            case 1:
            case 2:
            case 3:
                $result['start'] = Carbon::create($now->year, 1, 1)->timestamp;
                $result['end']   = Carbon::create($now->year, 3, 31, 23, 59, 59)->timestamp;
                break;
            case 4:
            case 5:
            case 6:
                $result['start'] = Carbon::create($now->year, 4, 1)->timestamp;
                $result['end']   = Carbon::create($now->year, 6, 30, 23, 59, 59)->timestamp;
                break;
            case 7:
            case 8:
            case 9:
                $result['start'] = Carbon::create($now->year, 7, 1)->timestamp;
                $result['end']   = Carbon::create($now->year, 9, 30, 23, 59, 59)->timestamp;
                break;
            case 10:
            case 11:
            case 12:
                $result['start'] = Carbon::create($now->year, 10, 1)->timestamp;
                $result['end']   = Carbon::create($now->year, 12, 31, 23, 59, 59)->timestamp;
                break;
        }
        return $result;
    }
}
