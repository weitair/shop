<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\Order\FinishEvent;
use Illuminate\Bus\Queueable;
use App\Models\Setting;
use App\Models\Order;
use Event;
use Log;

class ServiceClose implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    public $tries = 3; // 任务可以尝试的最大次数

    public $timeout = 30; // 任务可以执行的最大秒数 (超时时间)

    protected $order;

    protected $setting;

    protected $service;

    public function __construct(Order $order)
    {
        $this->order   = $order;
        $this->setting = Setting::getInstance('order.base')->fetch();
        $this->service = isset($this->setting['service']) ? $this->setting['service'] : 0;

        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($this->service * (60 * 60 * 24));
    }

    public function handle()
    {
        $this->order->order_progress = Order::ORDER_PROGRESS_FINISHED;
        $this->order->save();

        // 执行交易完成事件
        Event::dispatch(new FinishEvent($this->order));
    }

    /**
     * 任务失败的处理过程
     * @param \Exception $e
     */
    public function failed(\Exception $e)
    {
        Log::error('关闭订单售后定时任务：' . PHP_EOL);
        Log::error($e->getMessage() . PHP_EOL);
        Log::error($e->getTraceAsString() . PHP_EOL);
    }
}
