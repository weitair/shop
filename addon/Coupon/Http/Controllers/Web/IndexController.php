<?php

namespace Addon\Coupon\Http\Controllers\Web;

use Addon\Coupon\Logics\Web\CouponReceive;
use Addon\Coupon\Logics\Web\Coupon;
use App\Http\Controllers\Web\Controller;
use App\Helper\Date;

class IndexController extends Controller
{
    public function index()
    {
        $result['total']   = Coupon::count();
        $result['start']   = Coupon::where('status', Coupon::STATUS_START)->count();
        $result['receive'] = Coupon::where('status', Coupon::STATUS_START)->sum('received');
        $result['used']    = Coupon::where('status', Coupon::STATUS_START)->sum('used');
        $this->renderSuccess($result);
    }

    public function statistic()
    {
        $date = $this->request->get('date', 0);

        $result   = [];
        $length   = $date ? 30 : 7;
        $legend['data'] = ['领取人数', '使用人数'];

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
                        $series[$key]['data'][] = CouponReceive::whereBetween('receive_time', [$between['start'], $between['end']])
                            ->count();
                        break;
                    case 1:
                        $series[$key]['data'][] = CouponReceive::whereBetween('used_time', [$between['start'], $between['end']])
                            ->count();
                        break;
                }
            }
        }
        $result['legend'] = $legend;
        $result['series'] = $series;
        $this->renderSuccess($result);
    }
}
