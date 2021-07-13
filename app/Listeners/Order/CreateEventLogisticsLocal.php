<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;
use App\Logics\Api\StoreAddress;
use App\Models\Setting;
use App\Models\Order;

/**
 * 快递信息
 */
class CreateEventLogisticsLocal
{
    public function handle(CreateEvent $event)
    {
        $order   = $event->order;
        $setting = $event->setting;

        // 已选择了收货地址，并且物流方式为同城配送
        if ($order->logistics && $order->logistics_method == Order::LOGISTICS_METHOD_LOCAL) {
            foreach ($order->goods as $item) {
                // 计算总重
                $weight = bcmul($item->weight, $item->quantity);
                // 距离当前收货地址最近发货点
                $distance = StoreAddress::getShipmentMinDistance(
                    $order->logistics->lon,
                    $order->logistics->lat
                );

                // 最大可配送距离或者重量
                $total = $setting['logistics_local']['method'] == Setting::LOCAL_METHOD_DISTANCE ? $distance : $weight;
                $result = null;
                foreach ($setting['logistics_local']['item'] as $value) {
                    // 是否在配送范围
                    if ($total >= $value['min'] && $total <= $value['max']) {
                        $result = $value['fee'];
                    }
                }

                // 是否超过最大距离或最重重量
                if ($setting['logistics_local']['method'] == Setting::LOCAL_METHOD_DISTANCE) {
                    if ($weight > $setting['logistics_local']['weight']) {
                        $result = null;
                    }
                }
                if ($setting['logistics_local']['method'] == Setting::LOCAL_METHOD_WEIGHT) {
                    if ($distance > $setting['logistics_local']['distance']) {
                        $result = null;
                    }
                }

                if ($result === null) {
                    $item->logistics_price = 0; // 返回null商品超过配送距离或重量阈值
                    $item->error           = 1; // 商品错误
                    $order->error          = 1; // 全局错误
                    $order->message        = '商品不在配送范围，建议您更换收货地址或配送方式';
                } else {
                    $item->logistics_price   = $result;
                    $order->logistics_price += $result;
                }
            }
        }
    }
}
