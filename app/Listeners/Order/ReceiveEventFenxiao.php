<?php

namespace App\Listeners\Order;

use Nwidart\Modules\Facades\Module;
use App\Events\Order\ReceiveEvent;
use Event;

class ReceiveEventFenxiao
{
    public function handle(ReceiveEvent $event)
    {
        $order = $event->order;

        if (Module::has('Fenxiao')) {
            $setting = \Addon\Fenxiao\Models\Setting::getInstance('fenxiao.settle')->fetch();

            if ($setting && $setting['time'] == \Addon\Fenxiao\Models\Setting::TIME_FINISH) {
                Event::dispatch(new \Addon\Fenxiao\Events\SettleEvent($order));
            }
        }
    }
}
