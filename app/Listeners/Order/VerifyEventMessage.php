<?php

namespace App\Listeners\Order;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\VerifyEvent;
use App\Models\MessageTemplate;
use Log;

class VerifyEventMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(VerifyEvent $event)
    {
        $order = $event->order;
        $goods = $order->goods;

        $goods_name  = $goods[0]->goods_name;
        $goods_count = count($goods);
        $goods_name  = $goods_count > 1 ? $goods_name. '等' . $goods_count . '件商品' : $goods_name;

        MessageTemplate::getInstance('ORDER_VERIFY')->member(
            $order->member,
            ['ordersn' => $order->order_sn],
            [
                'page' => 'pages/index/index',
                'data' => [
                    'character_string11' => [
                        'value' => $order->order_sn,
                    ],
                    'thing1' => [
                        'value' => $goods_name,
                    ],
                    'time10' => [
                        'value' => date("Y-m-d H:i:s", time()),
                    ]
                ],
            ]
        );
    }

    /**
     * 处理失败任务。
     * @param VerifyEvent $event
     * @param \Exception $e
     */
    public function failed(VerifyEvent $event, \Exception $e)
    {
        Log::error('核销成功发送消息队列：' . PHP_EOL);
        Log::error($e->getMessage() . PHP_EOL);
        Log::error($e->getTraceAsString() . PHP_EOL);
    }
}
