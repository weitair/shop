<?php

namespace App\Logics\Web;

use App\Helper\Date;
use DB;

class StatisticMember
{
    public static function global(int $type)
    {
        $result   = [];
        $length   = $type ? 30 : 7;
        $legend['data'] = [
            '新增客户数',
            '活跃客户数',
            '下单客户数',
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
                        $series[$key]['data'][] = Member::whereBetween('register_time', [$between['start'], $between['end']])
                            ->count();
                        break;
                    case 1:
                        $series[$key]['data'][] = Member::whereBetween('last_login_time', [$between['start'], $between['end']])
                            ->count();
                        break;
                    case 2:
                        $series[$key]['data'][] = Order::where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                            ->whereBetween('order_time',[$between['start'], $between['end']])
                            ->count(DB::raw('DISTINCT(member_id)'));
                        break;
                }
            }
        }
        $result['legend'] = $legend;
        $result['series'] = $series;
        return $result;
    }

    public static function channel()
    {
        $result = [
            ['name' => '公众号', 'value' => 0],
            ['name' => '小程序', 'value' => 0],
            ['name' => 'H5', 'value' => 0],
        ];

        foreach ($result as $key => $item) {
            switch ($key) {
                case 0:
                    $result[$key]['value'] = Member::where('channel', Member::CHANNEL_WECHAT)->count();
                    break;
                case 1:
                    $result[$key]['value'] = Member::where('channel', Member::CHANNEL_WECHAT_APP)->count();
                    break;
                case 2:
                    $result[$key]['value'] = Member::where('channel', Member::CHANNEL_H5)->count();
                    break;
            }
        }
        return $result;
    }

    public static function province()
    {


        $data = Member::groupBy('province')
            ->select('province', DB::raw('count(province) as count'))
            ->orderBy('count', 'desc')
            ->get();

        $result = [];
        $other = 0;
        foreach ($data as $item) {
            if (self::inProvince($item->province)) {
                $result['xAxis']['data'][]  = $item->province;
                $result['series']['data'][] = $item->count;
            } else {
                $other += $item->count;
            }
        }
        $result['xAxis']['data'][]  = '其他';
        $result['series']['data'][] = $other;
        return $result;
    }

    private static function inProvince(string $province)
    {
        $array = ['北京市', '天津市', '上海市', '重庆市', '河北省', '山西省', '辽宁省', '吉林省', '黑龙江省', '江苏省',
            '浙江省', '安徽省', '福建省', '江西省', '山东省', '河南省', '湖北省', '湖南省', '广东省', '海南省', '四川省',
            '贵州省', '云南省', '陕西省', '甘肃省', '青海省', '台湾省','内蒙古自治区', '广西壮族自治区', '西藏自治区',
            '宁夏回族自治区', '新疆维吾尔自治区', '香港特别行政区', '澳门特别行政区'];

        foreach ($array as $name) {
            if (!empty($province) && strstr($name, $province) !== false) {
                return true;
            }
        }
        return false;
    }
}
