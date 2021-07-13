<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;

class CreateEventBase
{
    public function handle(CreateEvent $event)
    {
        $order   = $event->order;
        $params  = $event->params;

        $order->logistics_method  = $params['logistics'] < 0 ? $order->methods[0] : $params['logistics'];
        $order->coupon_id         = $params['coupon'];
        $order->invoice_status    = $params['invoice'];
        $order->message           = $params['message'];
        $order->channel           = $params['channel'];
        $order->payment_channel   = $params['payment_channel'];
    }
}
