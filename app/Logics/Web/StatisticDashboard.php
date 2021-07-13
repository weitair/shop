<?php

namespace App\Logics\Web;

use Illuminate\Database\Eloquent\Builder;
use App\Helper\Date;
use DB;

class StatisticDashboard
{
    /**
     * 访问人数
     * @param int $date
     * @return int[]
     */
    public static function uv(int $date)
    {
        $result = [
            'current' => 0,
            'before'  => 0
        ];
        switch ($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate  = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate  = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate  = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate  = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate  = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate  = Date::beforeMonth(2);
                break;
        }
        $current = Uv::whereBetween('entry_time', [$currentDate['start'], $currentDate['end']])->count();
        $before  = Uv::whereBetween('entry_time', [$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before']  = $before;
        $result['percent'] = yoy($current, $before);
        return $result;
    }

    /**
     * 新增订单数
     * @param int $date
     * @return int[]
     */
    public static function order(int $date)
    {
        $result = [
            'current' => 0,
            'before'  => 0
        ];
        switch ($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate  = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate  = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate  = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate  = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate  = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate  = Date::beforeMonth(2);
                break;
        }

        $current = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
            ->whereBetween('order_time', [$currentDate['start'], $currentDate['end']])
            ->count();
        $before = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
            ->whereBetween('order_time', [$beforeDate['start'], $beforeDate['end']])
            ->count();

        $result['current'] = $current;
        $result['before']  = $before;
        $result['percent'] = yoy($current, $before);
        return $result;
    }

    /**
     * 支付金额
     * @param int $date
     * @return int[]
     */
    public static function paymentSum(int $date)
    {
        $result = [
            'current' => 0,
            'before'  => 0
        ];
        switch ($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate  = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate  = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate  = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate  = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate  = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate  = Date::beforeMonth(2);
                break;
        }
        $current = Payment::where('status', Payment::STATUS_PAID)
            ->whereBetween('payment_time', [$currentDate['start'], $currentDate['end']])->sum('payment_price');
        $before = Payment::where('status', Payment::STATUS_PAID)
            ->whereBetween('payment_time', [$beforeDate['start'], $beforeDate['end']])->sum('payment_price');

        $result['current'] = bcdiv($current, 100, 2);
        $result['before']  = bcdiv($before, 100, 2);
        $result['percent'] = yoy($current, $before);
        return $result;
    }

    /**
     * 支付人数
     * @param int $date
     * @return int[]
     */
    public static function paymentCount(int $date)
    {
        $result = [
            'current' => 0,
            'before'  => 0
        ];
        switch ($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate  = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate  = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate  = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate  = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate  = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate  = Date::beforeMonth(2);
                break;
        }
        $current = Payment::where('status', Payment::STATUS_PAID)
            ->whereBetween('payment_time', [$currentDate['start'], $currentDate['end']])->count();
        $before = Payment::where('status', Payment::STATUS_PAID)
            ->whereBetween('payment_time', [$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before']  = $before;
        $result['percent'] = yoy($current, $before);
        return $result;
    }

    /**
     * 新增用户数
     * @param int $date
     * @return int[]
     */
    public static function memberNew(int $date)
    {
        $result = [
            'current' => 0,
            'before'  => 0
        ];
        switch ($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate  = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate  = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate  = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate  = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate  = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate  = Date::beforeMonth(2);
                break;
        }
        $current = Member::whereBetween('register_time', [$currentDate['start'], $currentDate['end']])->count();
        $before  = Member::whereBetween('register_time', [$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before']  = $before;
        $result['percent'] = yoy($current, $before);
        return $result;
    }

    /**
     * 老用户活跃数
     * @param int $date
     * @return int[]
     */
    public static function memberOld(int $date)
    {
        $result = [
            'current' => 0,
            'before'  => 0
        ];
        switch ($date) {
            case 0:
                $currentDate = Date::today();
                $beforeDate  = Date::yesterday();
                break;
            case 1:
                $currentDate = Date::yesterday();
                $beforeDate  = Date::beforeDay(2);
                break;
            case 2:
                $currentDate = Date::week();
                $beforeDate  = Date::beforeWeek(1);
                break;
            case 3:
                $currentDate = Date::beforeWeek(1);
                $beforeDate  = Date::beforeWeek(2);
                break;
            case 4:
                $currentDate = Date::month();
                $beforeDate  = Date::beforeMonth(1);
                break;
            case 5:
                $currentDate = Date::beforeMonth(1);
                $beforeDate  = Date::beforeMonth(2);
                break;
        }
        $current = Member::whereBetween('last_login_time', [$currentDate['start'], $currentDate['end']])->count();
        $before  = Member::whereBetween('last_login_time', [$beforeDate['start'], $beforeDate['end']])->count();
        $result['current'] = $current;
        $result['before']  = $before;
        $result['percent'] = yoy($current, $before);
        return $result;
    }

    /**
     * 商品销量排名
     * @param int $date
     * @return int[]
     */
    public static function goodsTop(int $date)
    {
        switch ($date) {
            case 0:
                $current = Date::today();
                break;
            case 1:
                $current = Date::yesterday();
                break;
            case 2:
                $current = Date::week();
                break;
            case 3:
                $current = Date::beforeWeek(1);
                break;
            case 4:
                $current = Date::month();
                break;
            case 5:
                $current = Date::beforeMonth(1);
                break;
        }

        return OrderGoods::whereHas('order', function (Builder $query) use ($current) {
            $query->whereBetween('order_time', [$current['start'], $current['end']]);
        })
            ->has('goods')
            ->with('goods')
            ->groupBy('goods_id')
            ->select('goods_id', DB::raw('sum(quantity) as quantity'))
            ->orderBy('quantity', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * 卡片数据
     * @return array
     */
    public static function card()
    {
        $result['member'] = Member::count();
        $result['order']  = Order::count();
        $result['payment'] = Payment::where('status', Payment::STATUS_PAID)->sum('payment_price') / 100;
        $result['goods']   = Goods::where('status', Goods::STATUS_ON)->count();
        return $result;
    }

    public static function todo()
    {
        // 订单处理
        $result['order'] = Order::where('order_status', Order::ORDER_STATUS_PAID)->get();
        $result['comment'] = OrderComment::with('member')
            ->where('status', OrderComment::STATUS_AWAIT)->get();
        return $result;
    }
}
