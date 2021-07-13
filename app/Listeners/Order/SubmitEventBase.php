<?php

namespace App\Listeners\Order;

use App\Events\Order\SubmitEvent;
use App\Exceptions\AppException;
use App\Jobs\OrderClose;
use App\Models\Setting;

class SubmitEventBase
{
    /**
     * 库存处理、销量处理、购物车处理
     * @param SubmitEvent $event
     * @throws AppException
     */
    public function handle(SubmitEvent $event)
    {
        $order   = $event->order;
        OrderClose::dispatch($order);

        $list    = $order->goods()->with(['goods', 'sku'])->get();
        $setting = Setting::getInstance('order.base')->fetch();

        foreach ($list as $item) {
            if ($item->sku->stock < $item->quantity) {
                throw new AppException('库存不足');
            }

            // 清理购物车
            $order->member->cart()->where('goods_sku_id', $item->goods_sku_id)->delete();

            // 是否下单减库存
            if ($setting['stock'] == Setting::ORDER_STOCK_PLAN_ORDER) {
                $item->goods->sales += $item->quantity; // 总销量增加
                $item->goods->stock -= $item->quantity; // 总库存减少
                $item->sku->sales   += $item->quantity; // Sku销量增加
                $item->sku->stock   -= $item->quantity; // Sku库存减少
                $item->push();
            }
        }
    }
}
