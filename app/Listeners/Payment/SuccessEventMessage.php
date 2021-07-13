<?php

namespace App\Listeners\Payment;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Payment\SuccessEvent;
use App\Models\MessageTemplate;
use App\Models\StoreEmployee;
use Log;

class SuccessEventMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(SuccessEvent $event)
    {
        $employee = StoreEmployee::orderList();
        foreach ($employee as $item) {
            MessageTemplate::getInstance('NEW_ORDER')->phone($item->phone);
        }
    }

    /**
     * 处理失败任务。
     * @param SuccessEvent $event
     * @param \Exception $exception
     */
    public function failed(SuccessEvent $event, \Exception $exception)
    {
        Log::error('支付成功发送短信' . PHP_EOL);
        Log::error($exception->getMessage() . PHP_EOL);
        Log::error($exception->getTraceAsString() . PHP_EOL);
    }
}
