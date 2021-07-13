<?php

namespace App\Listeners\Order;

use App\Events\Order\CloseEvent;
use App\Models\Setting;

class CloseEventGoods
{
    /**
     * 返还库存
     * @param CloseEvent $event
     * @return void
     */
    public function handle(CloseEvent $event)
    {
        $order   = $event->order;
        $setting = Setting::getInstance('order.base')->fetch();

        // 如果订单是下单减库存，关闭订单后都需将库存加回去
        if ($setting['stock'] == Setting::ORDER_STOCK_PLAN_ORDER) {
            $list = $order->goods()->with(['goods', 'sku'])->get();

            foreach ($list as $item) {
                // 商品可能已被删除，做一下判断
                if ($item->goods) {
                    $item->goods->sales -= $item->quantity; // 总销量减少
                    $item->goods->stock += $item->quantity; // 总库存增加
                    $item->sku->sales   -= $item->quantity; // Sku销量减少
                    $item->sku->stock   += $item->quantity; // Sku库存增加
                    $item->push();
                }
            }
        }
    }
}
