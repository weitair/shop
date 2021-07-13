<?php

namespace App\Listeners\Order;

use Nwidart\Modules\Facades\Module;
use App\Events\Order\CreateEvent;
use App\Models\Order;

/**
 * 满额、满件包邮
 */
class CreateEventFreeship
{
    public function handle(CreateEvent $event)
    {
        $order = $event->order;

        // 配送方式为自提的话，不继续
        if ($order->logistics_method == Order::LOGISTICS_METHOD_FETCH) {
            return true;
        }

        // 模块存在，才继续执行
        if (Module::has('Freeship')) {
            // 当前没有正在进行的活动，不继续
            if (empty($model = \Addon\Freeship\Logics\Api\Freeship::current())) {
                return true;
            }

            $logistics     = $model->logistics;     // 物流方式(-1：全部、0：快递、1：同城)
            $goods_limit   = $model->goods_limit;   // 活动商品(0：所有商品参加、1：指定商品参加、2：指定商品不参加)
            $goods         = $model->goods;         // 商品数据[1,2,3]
            $type          = $model->type;          // 免邮类型(0：整单包邮、1：仅活动商品包邮)
            $amount_status = $model->amount_status; // 满额包邮
            $amount        = $model->amount;        // 金额
            $count_status  = $model->count_status;  // 满件包邮
            $count         = $model->count;         // 件数

            // 限制了物理方式，判断是否和当前配送方式一直，否则不继续
            if ($logistics > 0 && $logistics != $order->logistics_method) {
                return true;
            }

            // 商品限制如果大于0，就执行商品范围判断
            $goods  = json_decode($goods);
            $global = false; // 用于判断整单包邮
            foreach ($order->goods as $item) {
                if ($goods_limit == 1) {
                    $status = in_array($item->goods_id, $goods) ? true : false;
                } elseif ($goods_limit == 2) {
                    $status = in_array($item->goods_id, $goods) ? false : true;
                } else {
                    $status = true;
                }

                // 有无参与活动的资格
                if ($status) {
                    if ($amount_status == 1) {
                        $condition = $item->goods_price >= $amount;
                        $item->logistics_price = $condition ? 0 : $item->logistics_price;
                        if ($condition) {
                            $global = true;
                        }
                    }
                    if ($count_status == 1) {
                        $condition = $item->quantity >= $count;
                        $item->logistics_price = $condition ? 0 : $item->logistics_price;
                        if ($condition) {
                            $global = true;
                        }
                    }
                }
            }

            // 继续计算整单包邮
            if ($type == 0 && $global) {
                foreach ($order->goods as $item) {
                    $item->logistics_price = 0;
                }
            }
        }
    }
}
