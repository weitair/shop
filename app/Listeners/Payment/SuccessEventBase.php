<?php

namespace App\Listeners\Payment;

use App\Events\Payment\SuccessEvent;
use App\Models\Setting;
use App\Models\Order;

class SuccessEventBase
{
    public function handle(SuccessEvent $event)
    {
        $payment = $event->payment;

        $order   = Order::with(['goods.goods', 'goods.sku'])->find($payment->order_id);
        $setting = Setting::getInstance('order.base')->fetch();

        foreach ($order->goods as $item) {
            // 是否支付减库存
            if ($setting['stock'] == Setting::ORDER_STOCK_PLAN_PAYMENT) {
                $item->goods->sales += $item->quantity; // 销量增加
                $item->goods->stock -= $item->quantity; // 总库存减少
                $item->sku->sales   += $item->quantity; // Sku销量增加
                $item->sku->stock   -= $item->quantity; // Sku库存减少
                $item->push();
            }
        }
        $order->payment_time   = time();
        $order->payment_status = Order::PAYMENT_STATUS_FINISHED;
        $order->order_progress = Order::ORDER_PROGRESS_START;
        $order->order_status   = Order::ORDER_STATUS_PAID;
        $order->save();
    }
}
