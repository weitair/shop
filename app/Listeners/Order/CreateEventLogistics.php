<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;
use App\Logics\Api\MemberAddress;
use App\Models\Order;

/**
 * 物流信息
 */
class CreateEventLogistics
{
    public function handle(CreateEvent $event)
    {
        $order   = $event->order;
        $params  = $event->params;

        if ($order->logistics_method != Order::LOGISTICS_METHOD_FETCH) {
            if ($params['address']) {
                $order->logistics = MemberAddress::detail($params['address']);
            } else {
                $order->logistics = MemberAddress::default($order->logistics_method);
            }
        }
    }
}
