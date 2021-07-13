<?php

namespace App\Logics\Web;

use Illuminate\Database\Eloquent\Builder;
use DB;

class StatisticGoods
{
    public static function card()
    {
        $result['online']  = Goods::where('status', Goods::STATUS_ON)->where('stock', '>', 0)->count();
        $result['offline'] = Goods::where('status', Goods::STATUS_OFF)->count();
        $result['sold']    = Goods::where('status', Goods::STATUS_ON)->where('stock', 0)->count();
        $result['recycle'] = Goods::onlyTrashed()->count();
        return $result;
    }

    public static function view()
    {
        return Goods::orderBy('views', 'desc')->limit(10)->get();
    }

    public static function sale()
    {
        return Goods::orderBy('sales', 'desc')->limit(10)->get();
    }

    public static function payment()
    {
        return OrderGoods::whereHas('order', function (Builder $query) {
            $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED);
        })
            ->has('goods')
            ->with('goods')
            ->groupBy('goods_id')
            ->select('goods_id', DB::raw('sum(payment_price) as payment_price'))
            ->orderBy('payment_price', 'desc')
            ->limit(10)
            ->get();
    }
}
