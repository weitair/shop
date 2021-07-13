<?php

namespace App\Logics\Web;

use App\Models\Order as OrderModel;
use Nwidart\Modules\Facades\Module;
use App\Events\Order\ShipmentEvent;
use App\Events\Order\ReceiveEvent;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Helper\Date;
use Event;
use Log;
use DB;

class Order extends OrderModel
{
    const SHIPMENT_FINISHED   = '商品已全部发货';
    const SHIPMENT_ZERO_GOODS = '没有商品被发货';
    const ORDER_STATUS_ERROR  = '订单状态异常';

    public static function getList()
    {
        $request    = Request::capture();
        $filter     = [];
        $order      = 'id desc';
        $sn         = $request->get('sn');
        $status     = $request->get('status');
        $date       = $request->get('date');
        $between    = $request->get('between');
        $logistics  = $request->get('logistics');
        $goods_name = $request->get('goods_name');
        $channel    = $request->get('channel');
        $sort       = $request->get('sort');

        if (!empty($sn)) {
            $filter[] = ['order_sn', 'like', "%$sn%"];
        }
        if (is_numeric($status)) {
            $filter[] = ['order_status', '=', $status];
        }
        if (is_numeric($logistics)) {
            $filter[] = ['logistics_method', '=', $logistics];
        }
        if (is_numeric($channel)) {
            $filter[] = ['channel', $channel];
        }
        if (is_numeric($date)) {
            switch ($date) {
                case 0:
                    $date = Date::today();
                    $filter[] = ['order_time', '>=', $date['start']];
                    $filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 1:
                    $date = Date::yesterday();
                    $filter[] = ['order_time', '>=', $date['start']];
                    $filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 2:
                    $date = Date::week();
                    $filter[] = ['order_time', '>=', $date['start']];
                    $filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 3:
                    $date = Date::month();
                    $filter[] = ['order_time', '>=', $date['start']];
                    $filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 4:
                    $date = Date::year();
                    $filter[] = ['order_time', '>=', $date['start']];
                    $filter[] = ['order_time', '<=', $date['end']];
                    break;
            }
        }

        if (!empty($between)) {
            if (is_array($between)) {
                $filter[] = ['order_time', '>=', ($between[0] / 1000)];
                $filter[] = ['order_time', '<=', ($between[1] / 1000)];
            }
        }

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with(['goods', 'member'])
            ->when($goods_name, function ($query) use ($goods_name) {
                return $query->whereHas('goods', function ($query) use ($goods_name) {
                    $query->where('goods_name', 'like', "%$goods_name%");
                });
            })
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with([
            'goods',
            'invoice',
            'logistics',
            'package.item.goods',
            'package.express',
            'fetch',
            'member'
        ])->findOrFail($id);
    }

    public static function logistic(array $data)
    {
        $order = self::detail($data['order_id']);
        return $order->logistics->fill($data)->save();
    }

    /**
     * 发货
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public static function shipment(array $data)
    {
        try {
            DB::beginTransaction();
            $order = self::detail($data['order_id']);

            if ($order->shipment_status == self::SHIPMENT_STATUS_FINISHED) {
                throw new AppException(self::SHIPMENT_FINISHED);
            }

            if (empty($data['goods_id']) && $order->logistics_method == self::LOGISTICS_METHOD_EXPRESS) {
                throw new AppException(self::SHIPMENT_ZERO_GOODS);
            }

            if (!empty($data['employee_id'])) {
                $employee         = StoreEmployee::find($data['employee_id']);
                $data['delivery'] = $employee->name;
                $data['phone']    = $employee->phone;
            }

            // 生成主包裹信息
            $package = $order->package()->create([
                'express_id'  => empty($data['express_id']) ? 0 : $data['express_id'],
                'express_sn'  => empty($data['express_sn']) ? '' : $data['express_sn'],
                'employee_id' => empty($data['employee_id']) ? 0 : $data['employee_id'],
                'delivery'    => empty($data['delivery']) ? '' : $data['delivery'],
                'phone'       => empty($data['phone']) ? '' : $data['phone'],
            ]);
            // 生成包裹明细
            foreach ($order->goods as $item) {
                if (in_array($item->id, $data['goods_id'])
                    || $order->logistics_method == self::LOGISTICS_METHOD_LOCAL) {
                    $package->item()->create([
                        'goods_id' => $item->id,
                        'order_id' => $item->order_id,
                    ]);
                    $item->shipment_time   = time();
                    $item->shipment_status = OrderGoods::SHIPMENT_STATUS_FINISHED;
                    $item->save();
                }
            }
            // 统计未发货商品数量
            $count = $order->goods()->where('shipment_status', OrderGoods::SHIPMENT_STATUS_UN)->count();
            // 0 则表示都发完了，可以更新主表状态了
            $order->shipment_status = self::SHIPMENT_STATUS_PARTIAL; // 默认为部分发货

            if ($count === 0) {
                $setting                 = Setting::getInstance('order.base')->fetch();
                $shipment_time           = time();
                $order->shipment_time    = $shipment_time;
                $order->shipment_status  = self::SHIPMENT_STATUS_FINISHED;
                $order->finish_time_auto = $shipment_time + $setting['receive'] * (60 * 60 * 24); // 订单自动收货的时间
                $order->order_status     = self::ORDER_STATUS_SHIPPED;

                // 执行事件和任务
                Event::dispatch(new ShipmentEvent($order));
            }
            $order->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 备注
     * @param array $data
     * @return mixed
     */
    public static function remark(array $data)
    {
        $order = self::detail($data['id']);
        $order->remark = $data['remark'];
        return $order->save();
    }

    /**
     * 改价并重新分摊金额
     * @param array $data
     * @return bool
     * @throws AppException
     */
    public static function price(array $data)
    {
        $order  = self::detail($data['id']);

        if ($order->order_status != self::ORDER_STATUS_CREATED) {
            throw new AppException(self::ORDER_STATUS_ERROR);
        }

        $order->change_price  = $data['change'];
        $order->payment_price = round($order->payment_price + $order->change_price, 2); //调整后的待支付金额
        $order->payment_price = $order->payment_price < 0 ? 0 : $order->payment_price;

        $goods_count = $order->goods->count();
        $price_sum   = 0;
        foreach ($order->goods as $key => $item) {
            $rate = round($item->goods_price / $order->goods_price, 2); // 所占百分比

            if ($goods_count - 1 == $key) {
                $item->payment_price = round($order->payment_price - $price_sum, 2);
            } else {
                $item->payment_price = round($rate * $order->payment_price, 2);
                $price_sum           = round($item->payment_price + $price_sum, 2);
            }
            $item->save();
        }
        return $order->save();
    }

    /**
     * 订单签收
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public static function receive(int $id)
    {
        try {
            DB::beginTransaction();
            $order = self::detail($id);
            if ($order->order_status == self::ORDER_STATUS_SHIPPED) {
                $order->order_status   = self::ORDER_STATUS_FINISHED;
                $order->receive_status = self::RECEIVE_STATUS_FINISHED;
                $order->finish_time    = time();
                $result = $order->save();
                Event::dispatch(new ReceiveEvent($order));
                DB::commit();
                return $result;
            }
            return false;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 打印小票
     * @param int $id
     * @return bool
     */
    public static function prints(int $id)
    {
        if (Module::has('Reciept')) {
            $order = self::with(['logistics', 'fetch', 'goods', 'member'])->findOrFail($id);
            return \Addon\Reciept\Services\Prints::order($order);
        }
        return false;
    }
}
