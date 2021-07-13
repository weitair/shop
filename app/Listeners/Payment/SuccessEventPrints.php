<?php

namespace App\Listeners\Payment;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Payment\SuccessEvent;
use Nwidart\Modules\Facades\Module;
use App\Models\Order;
use Log;

class SuccessEventPrints implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(SuccessEvent $event)
    {
        $payment = $event->payment;

        if (Module::has('Reciept')) {
            $order = Order::with(['logistics', 'fetch', 'goods', 'member'])->findOrFail($payment->order_id);
            return \Addon\Reciept\Services\Prints::order($order);
        }
        return false;
    }

    /**
     * 处理失败任务。
     * @param SuccessEvent $event
     * @param \Exception $e
     */
    public function failed(SuccessEvent $event, \Exception $e)
    {
        Log::error('支付成功小票打印队列：' . PHP_EOL);
        Log::error($e->getMessage() . PHP_EOL);
        Log::error($e->getTraceAsString() . PHP_EOL);
    }
}
