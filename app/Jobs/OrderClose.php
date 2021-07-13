<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\Order\CloseEvent;
use Illuminate\Bus\Queueable;
use App\Models\Setting;
use App\Models\Order;
use Event;
use Log;

class OrderClose implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    public $tries = 3; // 任务可以尝试的最大次数

    public $timeout = 30; // 任务可以执行的最大秒数 (超时时间)

    protected $order;

    protected $setting;

    protected $close;

    public function __construct(Order $order)
    {
        $this->order   = $order;
        $this->setting = Setting::getInstance('order.base')->fetch();
        $this->close   = isset($this->setting['close']) ? $this->setting['close'] : 0;

        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($this->close * 60);
    }

    public function handle()
    {
        if ($this->close > 0) {
            // 订单尚未支付并且订单还未被用户取消
            if ($this->order->order_status == Order::ORDER_STATUS_CREATED) {
                $this->order->close_time     = time();
                $this->order->finish_time    = time();
                $this->order->order_status   = Order::ORDER_STATUS_CLOSED;
                $this->order->order_progress = Order::ORDER_PROGRESS_FINISHED;
                $this->order->save();

                Event::dispatch(new CloseEvent($this->order)); // 执行关闭订单事件
            }
        }
    }

    /**
     * 任务失败的处理过程
     * @param \Exception $e
     */
    public function failed(\Exception $e)
    {
        Log::error('订单关闭定时任务：' . PHP_EOL);
        Log::error($e->getMessage() . PHP_EOL);
    }
}
