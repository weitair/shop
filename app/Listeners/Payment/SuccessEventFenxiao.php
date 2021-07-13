<?php

namespace App\Listeners\Payment;

use App\Events\Payment\SuccessEvent;
use Nwidart\Modules\Facades\Module;
use App\Models\Order;
use Event;

class SuccessEventFenxiao
{
    public function handle(SuccessEvent $event)
    {
        $payment = $event->payment;

        if (Module::has('Fenxiao')) {
            $order = Order::find($payment->order_id);
            Event::dispatch(new \Addon\Fenxiao\Events\RewardSaleEvent($order));
        }
    }
}
