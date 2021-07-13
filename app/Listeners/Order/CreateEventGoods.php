<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;
use App\Logics\Api\GoodsSku;
use App\Models\OrderGoods;

/**
 * 商品信息
 */
class CreateEventGoods
{
    public function handle(CreateEvent $event)
    {
        $order  = $event->order;
        $params = $event->params;

        foreach ($params['sku'] as $item) {
            $sku                 = GoodsSku::detail($item['id']);
            $goods               = new OrderGoods;
            $goods->goods        = $sku->goods;
            $goods->goods_id     = $sku->goods->id;
            $goods->goods_name   = $sku->goods->goods_name;
            $goods->image        = $sku->image ? $sku->image : $sku->goods->image;
            $goods->goods_sku_id = $sku->id;
            $goods->sku_sn       = $sku->sku_sn;
            $goods->sku_name     = $sku->sku_name;
            $goods->sales_price  = $sku->sales_price;
            $goods->line_price   = $sku->line_price;
            $goods->cost_price   = $sku->cost_price;
            $goods->weight       = $sku->weight;
            $goods->volume       = $sku->volume;
            $goods->quantity     = $item['quantity'];
            $goods->goods_price  = round($goods->sales_price * $goods->quantity, 2);
            $order->goods[]      = $goods;
            $order->goods_price += $goods->goods_price;

            if ($goods->quantity < $sku->goods->min_quantity) {
                $order->error   = 1;
                $order->message = '部分商品未达起购数量';
            }
            if ($sku->goods->quota_quantity > 0 && $goods->quantity > $sku->goods->quota_quantity) {
                $order->error   = 1;
                $order->message = '部分商品超过限购数量';
            }
        }
    }
}
