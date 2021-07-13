<?php

namespace App\Listeners\Order;

use App\Events\Order\ShipmentEvent;
use App\Jobs\OrderReceive;

class ShipmentEventBase
{
    public function handle(ShipmentEvent $event)
    {
        $order = $event->order;
        // 自动签收任务
        OrderReceive::dispatch($order);
    }
}
