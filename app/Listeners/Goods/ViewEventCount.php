<?php

namespace App\Listeners\Goods;

use App\Events\Goods\ViewEvent;

class ViewEventCount
{
    public function handle(ViewEvent $event)
    {
        $event->goods->views += 1;
        $event->goods->save();
    }
}
