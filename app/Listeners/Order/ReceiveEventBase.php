<?php

namespace App\Listeners\Order;

use App\Events\Order\ReceiveEvent;
use App\Jobs\ServiceClose;

class ReceiveEventBase
{
    public function handle(ReceiveEvent $event)
    {
        $order = $event->order;
        // 定时关闭售后入口
        ServiceClose::dispatch($order);
    }
}
