<?php

namespace App\Listeners\Order;

use Nwidart\Modules\Facades\Module;
use App\Events\Order\FinishEvent;
use Event;

class FinishEventFenxiao
{
    public function handle(FinishEvent $event)
    {
        $order = $event->order;

        if (Module::has('Fenxiao')) {
            $setting = \Addon\Fenxiao\Models\Setting::getInstance('fenxiao.settle')->fetch();

            if ($setting && $setting['time'] == \Addon\Fenxiao\Models\Setting::TIME_SERVICE_CLASE) {
                Event::dispatch(new \Addon\Fenxiao\Events\SettleEvent($order));
            }
        }
    }
}
