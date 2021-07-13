<?php

if (!function_exists('token_hash')) {
    function token_hash($id = '', $terminal = 'admin')
    {
        return md5(
            $id . time() . $terminal
        );
    }
}

if (!function_exists('get_token')) {
    function get_token()
    {
        $request = Illuminate\Http\Request::capture();

        if ($token = $request->query('token')) {
            return $token;
        }
        return $request->header('X-Token', '');
    }
}

if (!function_exists('get_sign')) {
    function get_sign()
    {
        $request = Illuminate\Http\Request::capture();
        return $request->header('X-Sign', '');
    }
}

if (!function_exists('get_timestamp')) {
    function get_timestamp()
    {
        $request = Illuminate\Http\Request::capture();
        $timestamp = $request->query('timestamp');

        if (empty($timestamp)) {
            $timestamp = $request->input('timestamp');
        }
        return $timestamp;
    }
}

if (!function_exists('get_sn')) {
    /**
     * 获取编号
     * @return string
     */
    function get_sn()
    {
        return date('Ymd') . str_pad(mt_rand(1, 9999999), 8, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('get_random_number')) {
    /**
     * 获取随机数
     * @return string
     */
    function get_random_number($len = 4)
    {
        return rand(pow(10, ($len - 1)), pow(10, $len) - 1);
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端 IP 地址
     * @return mixed|string
     */
    function get_client_ip()
    {
        static $realip = null;
        if ($realip !== null) {
            return $realip;
        }
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr as $ip) {
                    $ip = trim($ip);

                    if ($ip != 'unknown') {
                        $realip = $ip;

                        break;
                    }
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $realip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $realip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        // 使用正则验证IP地址的有效性，防止伪造IP地址进行SQL注入攻击
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
        return $realip;
    }
}

if (!function_exists('str_replace_first')) {
    /**
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return string
     */
    function str_replace_first($search, $replace, $subject)
    {
        return Str::replaceFirst($search, $replace, $subject);
    }
}

if (!function_exists('get_distance')) {
    /**
     * 计算两点之间的距离
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @param $unit // m，km
     * @param $decimal // 位数
     * @return float
     */
    function get_distance($lng1, $lat1, $lng2, $lat2, $unit = 2, $decimal = 2)
    {
        $lng1 = floatval($lng1);
        $lat1 = floatval($lat1);
        $lng2 = floatval($lng2);
        $lat2 = floatval($lat2);

        $EARTH_RADIUS = 6370.996; // 地球半径系数
        $PI = 3.1415926535898;

        $radLat1 = $lat1 * $PI / 180.0;
        $radLat2 = $lat2 * $PI / 180.0;

        $radLng1 = $lng1 * $PI / 180.0;
        $radLng2 = $lng2 * $PI / 180.0;

        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        $distance = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $distance = $distance * $EARTH_RADIUS * 1000;

        if ($unit === 2) {
            $distance /= 1000;
        }

        return round($distance, $decimal);
    }
}

if (!function_exists('get_fetch_times')) {
    /**
     * 获取自提订单的自提预约时间
     * @param $today_fetch
     * @param $business_begin
     * @param $business_end
     * @return mixed
     */
    function get_fetch_time($today_fetch, $business_begin, $business_end)
    {
        $times[] = [
            'text' => '今日',
            'disabled' => $today_fetch == 10
        ];
        $times[] = [
            'text' => '明日',
            'disabled' => false
        ];
        $id = 1;
        $h = (int) date("h", time());
        foreach ($times as $key => $day) {
            for ($i = 0; $i < 24; $i++) {
                if ($key == 0) {
                    if ($h < $i) {
                        $times[$key]['children'][] = [
                            'text' => $i . ':00-' . ($i + 1) . ':00',
                            'id' => $id
                        ];
                        $id++;
                    }
                } else {
                    $times[$key]['children'][] = [
                        'text' => $i . ':00-' . ($i + 1) . ':00',
                        'id' => $id
                    ];
                    $id++;
                }
            }
        }
        return $times;
    }
}

if (!function_exists('yoy')) {
    /**
     * 同比计算
     * @param $current
     * @param $before
     * @return float|int
     */
    function yoy($current, $before)
    {
        if ($current == $before) {
            return 0;
        }
        // 上期数据为0，没有可比性，直接返回100
        if ($before === 0 && $current > 0) {
            return 100;
        }
        // 环比增长率=（本期数-上期数）/上期数×100%
        $yoy = bcmul(
            bcdiv(
                bcsub(
                    $current,
                    $before,
                    2
                ),
                $before,
                2
            ),
            100,
            0
        );
        if ((int)$yoy > 100) {
            return 100;
        }
        return $yoy;
    }
}

if (!function_exists('conversion_rate')) {
    /**
     * 转化率计算
     * @param $click
     * @param $value
     * @return float|int
     */
    function conversion_rate($click, $value)
    {
        if (($click + $value) == 0 && $click == $value) {
            return 0;
        }
        if ($click === 0) {
            return 100;
        }
        return bcmul(bcdiv($value, $click, 2), 100, 0);
    }
}

if (!function_exists('diff_rate')) {
    function diff_rate($first, $second)
    {
        if ($second != 0) {
            $result = sprintf('%.2f', (($first - $second) / $second) * 100) . '%';
        } else if ($second == 0 & $first != 0) {
            $result = '100%';
        } else {
            $result = '0%';
        }
        return $result;
    }
}

if (!function_exists('price')) {
    /**
     * 价格精度计算
     * @param $n1 // 第一个数
     * @param $symbol // 计算符号 + - * / %
     * @param $n2 // 第二个数
     * @param string $scale // 精度 默认为小数点后两位
     * @return string|null
     */
    function price($n1, $symbol, $n2, $scale = '2')
    {
        switch ($symbol) {
            case "+":
                $result = bcadd($n1, $n2, $scale);
                break;
            case "-":
                $result = bcsub($n1, $n2, $scale);
                break;
            case "*":
                $result = bcmul($n1, $n2, $scale);
                break;
            case "/":
                $result = bcdiv($n1, $n2, $scale);
                break;
            case "%":
                $result = bcmod($n1, $n2, $scale);
                break;
            default:
                $result = '';
                break;
        }
        return $result;
    }
}
