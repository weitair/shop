<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\Order\ReceiveEvent;
use Illuminate\Bus\Queueable;
use App\Models\Setting;
use App\Models\Order;
use Event;
use Log;

class OrderReceive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    public $tries = 3; // 任务可以尝试的最大次数

    public $timeout = 30; // 任务可以执行的最大秒数 (超时时间)

    protected $order;

    protected $setting;

    protected $receive;

    /**
     * Create a new job instance.
     * Order序列化的是主键ID，模型会被重新获取
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order   = $order;
        $this->setting = Setting::getInstance('order.base')->fetch();
        $this->receive = isset($this->setting['receive']) ? $this->setting['receive'] : 0;

        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($this->receive * (60 * 60 * 24));
    }

    public function handle()
    {
        if ($this->receive > 0) {
            // 订单尚未签收
            if ($this->order->order_status == Order::ORDER_STATUS_SHIPPED) {
                $this->order->finish_time    = time();
                $this->order->receive_status = Order::RECEIVE_STATUS_FINISHED;
                $this->order->order_status   = Order::ORDER_STATUS_FINISHED;
                $this->order->save();

                // 执行签收订单事件
                Event::dispatch(new ReceiveEvent($this->order));
            }
        }
    }

    /**
     * 任务失败的处理过程
     * @param \Exception $e
     */
    public function failed(\Exception $e)
    {
        Log::error('订单签收定时任务：' . PHP_EOL);
        Log::error($e->getMessage() . PHP_EOL);
        Log::error($e->getTraceAsString() . PHP_EOL);
    }
}
