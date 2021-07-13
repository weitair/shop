<?php

namespace App\Listeners\Order;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\ShipmentEvent;
use App\Models\MessageTemplate;

class ShipmentEventMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ShipmentEvent $event)
    {
        $order = $event->order;
        $goods = $order->goods;

        $goods_name  = $goods[0]->goods_name;
        $goods_count = count($goods);
        $goods_name  = $goods_count > 1 ? $goods_name. '等' . $goods_count . '件商品' : $goods_name;

        MessageTemplate::getInstance('ORDER_SHIPPED')->member(
            $order->member,
            ['ordersn' => $order->order_sn],
            [
                'page' => 'pages/index/index',
                'data' => [
                    'character_string2' => [
                        'value' => $order->order_sn,
                    ],
                    'thing14' => [
                        'value' => $goods_name,
                    ],
                    'date3' => [
                        'value' => date("Y-m-d H:i:s", time()),
                    ],
                    'thing6' => [
                        'value' => '无',
                    ],
                ],
            ]
        );
    }
}
