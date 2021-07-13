<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;
use App\Logics\Api\Template;
use App\Models\Goods;
use App\Models\Order;

/**
 * 快递信息
 */
class CreateEventLogisticsExpress
{
    public function handle(CreateEvent $event)
    {
        $order = $event->order;

        // 已选择了收货地址，并且物流方式为快递
        if ($order->logistics && $order->logistics_method == Order::LOGISTICS_METHOD_EXPRESS) {
            foreach ($order->goods as $item) {
                if ($item->goods->logistics_unite == Goods::LOGISTICS_UNITE_ON) {
                    $item->logistics_price = $item->goods->logistics_price;
                } else {
                    $weight = bcmul($item->weight, $item->quantity); // 计算总重
                    $result = Template::getFee(
                        $item->goods->template_id,
                        $item->quantity,
                        $weight,
                        $order->logistics->city
                    );

                    if ($result === null) {
                        $item->logistics_price = 0; // 不在配送范围，配送费返回 0
                        $item->error           = 1; // 商品错误
                        $order->error          = 1; // 全局错误
                        $order->message        = '部分商品不在配送范围，建议您更换收货地址或配送方式';
                    } else {
                        $item->logistics_price   = $result;
                        $order->logistics_price += $result;
                    }
                }
            }
        }
    }
}
