<?php

namespace App\Listeners\Order;

use App\Events\Order\VerifyEvent;
use App\Models\OrderFetch;
use App\Jobs\OrderReceive;
use App\Logics\Web\Order;
use App\Models\OrderGoods;
use App\Models\Setting;

class VerifyEventBase
{
    public function handle(VerifyEvent $event)
    {
        $order  = $event->order;
        $verify = $event->verify;

        // 发货
        $setting                 = Setting::getInstance('order.base')->fetch();
        $shipment_time           = time();
        $order->shipment_time    = $shipment_time;
        $order->finish_time_auto = $shipment_time + $setting['receive'] * (60 * 60 * 24); // 订单自动收货的时间
        $order->shipment_status  = Order::SHIPMENT_STATUS_FINISHED;
        $order->order_status     = Order::ORDER_STATUS_SHIPPED;
        $order->save();

        // 生成主包裹信息
        $package = $order->package()->create([
            'verifier' => $verify->verifier,
        ]);
        // 生成包裹明细
        foreach ($order->goods as $item) {
            $package->item()->create([
                'goods_id' => $item->id,
                'order_id' => $item->order_id,
            ]);
            $item->shipment_time   = time();
            $item->shipment_status = OrderGoods::SHIPMENT_STATUS_FINISHED;
            $item->save();
        }

        // 处理自提表的数据
        $order->fetch->fetch_time   = time();
        $order->fetch->fetch_status = OrderFetch::FETCH_STATUS_FINISH;
        $order->fetch->save();

        OrderReceive::dispatch($order);
    }
}
