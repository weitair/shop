<?php

namespace App\Logics\Api;

use App\Models\MessageTemplate;
use App\Models\Order as OrderModel;
use Addon\Coupon\Logics\Api\CouponReceive;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Order\ReceiveEvent;
use App\Events\Order\SubmitEvent;
use App\Events\Order\CreateEvent;
use App\Events\Order\CloseEvent;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Models\OrderFetch;
use App\Models\Setting;
use Carbon\Carbon;
use Event;
use Log;
use DB;

class Order extends OrderModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('delete_status', function (Builder $builder) {
            $builder->where('delete_status', self::DELETE_STATUS_OFF);
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $status = $request->get('status', -1);
        $filter = [];
        switch ($status) {
            case self::ORDER_STATUS_CREATED:
            case self::ORDER_STATUS_PAID:
            case self::ORDER_STATUS_SHIPPED:
                $filter['order_status'] = $status;
                break;
            case self::ORDER_STATUS_FINISHED:
                $filter[] = ['order_status', '=',self::ORDER_STATUS_FINISHED];
                $filter[] = ['comment_status', '=', self::COMMENT_STATUS_UN];
        }

        return Member::user()->order()->with('goods')
            ->where($filter)
            ->orderBy('id', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['logistics', 'fetch', 'goods', 'member'])
            ->where('member_id', Member::id())
            ->findOrFail($id);
    }

    /**
     * 确认订单
     * @param array $params
     * @return static|null
     * @throws AppException
     */
    public static function confirm(array $params)
    {
        // 设置
        $setting['order']           = Setting::getInstance('order.base')->fetch();
        $setting['logistics_base']  = Setting::getInstance('logistics.base')->fetch();
        $setting['logistics_local'] = Setting::getInstance('logistics.local')->fetch();

        $order                   = new static;
        $order->error            = 0;
        $order->methods          = $setting['logistics_base']['method'];

        Event::dispatch(new CreateEvent($order, $params, $setting));
        $order->logisticsTotal($setting['logistics_base']); // 运费合计
        $order->paymentTotal(); // 实际支付价格计算
        $order->couponList(); // 可用优惠卷

        // 如果是自提，查询可自提的地址信息
        $order->store = [];
        if ($order->logistics_method == self::LOGISTICS_METHOD_FETCH) {
            $order->store = StoreAddress::getFetchStore($params['lon'], $params['lat']);
        }

        // 订阅消息
        $template = MessageTemplate::select('weapp_template_id')
            ->whereIn('key', ['ORDER_SHIPPED', 'ORDER_VERIFY'])
            ->where('weapp_status', MessageTemplate::WEAPP_STATUS)
            ->get();

        $template_id = [];
        foreach ($template as $item) {
            $template_id[] = $item->weapp_template_id;
        }
        $order['subscribe'] = $template_id;

        $order->time = self::getTime();
        $order->setting = $setting;
        return $order;
    }

    /**
     * 创建订单
     * @param array $params
     * @return false|static
     * @throws AppException
     */
    public static function create(array $params)
    {
        try {
            DB::beginTransaction();

            // 设置
            $setting['order']           = Setting::getInstance('order.base')->fetch();
            $setting['logistics_base']  = Setting::getInstance('logistics.base')->fetch();
            $setting['logistics_local'] = Setting::getInstance('logistics.local')->fetch();

            $order = new static;
            Event::dispatch(new CreateEvent($order, $params, $setting));
            $order->logisticsTotal($setting['logistics_base']); // 运费合计
            $order->paymentTotal(); // 实际支付价格计算

            $submit                  = new static($order->toArray());
            $submit->order_sn        = get_sn();
            $submit->member_id       = Member::id();
            $submit->order_time      = time();
            $submit->close_time_auto = time() + $setting['order']['close'] * 60; // 订单自动关闭的时间
            $submit->save();

            foreach ($order->goods as $item) {
                $submit->goods()->create($item->toArray());
            }

            if ($order->logistics) {
                $submit->logistics()->create($order->logistics->makeHidden('id')->toArray());
            }

            if ($order->fetch) {
                while(OrderFetch::where('verify_code', $order->fetch->verify_code)->first()) {
                    $order->fetch->verify_code = get_random_number(12);
                }
                $submit->fetch()->create($order->fetch->toArray());
            }

            if ($order->invoice) {
                $submit->invoice()->create($order->invoice->toArray());
            }

            $submit->apportion();
            $submit->save();
            Event::dispatch(new SubmitEvent($submit));
            DB::commit();
            return $submit;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 获取时间
     * @return array
     */
    public static function getTime()
    {
        $times[] = [
            'text'     => '今日',
            'value'    => Carbon::today()->toDateString()
        ];
        $times[] = [
            'text'     => '明日',
            'value'    => Carbon::tomorrow()->toDateString(),
            'disabled' => false
        ];

        $begin = 0;
        $end   = 2400;
        foreach ($times as $key => $day) {
            for ($i = 0; $i < 24; $i++) {
                if ($i * 100 >= $begin && $i * 100 < $end) {
                    $times[$key]['children'][] = [
                        'text'     => $i . ':00',
                        'value'    => $i,
//                            'disabled' => $hour >= $i
                    ];
                }
            }
        }
        return $times;
    }

    /**
     * 可用优惠卷
     */
    private function couponList()
    {
        $goods_id = [];
        foreach ($this->goods as $item) {
            $goods_id[] = $item->goods_id;
        }

        $this->coupon = CouponReceive::where(function ($query) use ($goods_id) {
            $query->where('goods_limit', CouponReceive::GOODS_LIMIT_ALL)
                ->orWhere(function ($query) use ($goods_id) {
                    $query->where('goods_limit', CouponReceive::GOODS_LIMIT_AVAILABLE)
                        ->whereHas('goods', function (Builder $query) use ($goods_id) {
                            $query->whereIn('goods_id', $goods_id);
                        });
                })
                ->orWhere(function ($query) use ($goods_id) {
                    $query->where('goods_limit', CouponReceive::GOODS_LIMIT_UNAVAILABLE)
                        ->whereHas('goods', function (Builder $query) use ($goods_id) {
                            $query->whereNotIn('goods_id', $goods_id);
                        });
                });
        })
            ->where('member_id', Member::id())
            ->where('condition', '<=', $this->goods_price * 100)
            ->where('expire_time', '>', time())
            ->where('status', CouponReceive::STATUS_UNUSED)
            ->orderBy('expire_time', 'asc')
            ->get();
    }

    /**
     * 运费合计
     */
    private function logisticsTotal(array $setting)
    {
        $logistics_price = [];
        foreach ($this->goods as $item) {
            $logistics_price[] = $item->logistics_price;
        }

        switch ($setting['freight_plan']) {
            case Setting::LOGISTICS_PLAN_TOTAL:
                $this->logistics_price = (float) array_sum($logistics_price);
                break;
            case Setting::LOGISTICS_PLAN_MIN:
                $this->logistics_price = (float) min($logistics_price);
                break;
            case Setting::LOGISTICS_PLAN_MAX:
                $this->logistics_price = (float) max($logistics_price);
                break;
        }
    }

    /**
     * 实际支付价格(订单总金额 = 商品总金额 + 运费 - 总优惠金额 + 改价的金额)
     */
    private function paymentTotal()
    {
        $this->payment_price = $this->goods_price + $this->logistics_price - $this->coupon_price + $this->change_price;
        $this->payment_price = $this->payment_price < 0 ? 0 : $this->payment_price;
    }

    /**
     * 分摊计算，将总的支付金额分摊到每个sku
     * 单个商品优惠后的价格 = 商品价格 – 总优惠金额 * （商品金额 / 订单总金额）
     */
    private function apportion()
    {
        $goods_count = $this->goods->count();
        $price_sum   = 0;
        foreach ($this->goods as $key => $item) {
            // 使用了优惠卷、有优惠金额、运费等才进行分摊计算
            if ($this->coupon_price > 0 || $this->discount_price > 0 || $this->logistics_price > 0) {
                $rate = round($item->goods_price / $this->goods_price, 2); // 所占百分比

                if ($goods_count - 1 == $key) {
                    $item->payment_price = round($this->payment_price - $price_sum, 2);
                } else {
                    $item->payment_price = round($rate * $this->payment_price, 2);
                    $price_sum           = round($item->payment_price + $price_sum, 2);
                }
            } else {
                $item->payment_price = $item->goods_price;
            }
            $item->save();
        }
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
     * 评论
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public static function comments(array $data)
    {
        try {
            DB::beginTransaction();
            $order   = self::findOrFail($data['id']);
            $params  = json_decode($data['comment']);

            if ($order->comment_status == self::COMMENT_STATUS_UN) {
                foreach ($params as $item) {
                    $comment = $order->comment()->create([
                        'rate'         => $item->rate,
                        'satisfaction' => $item->satisfaction,
                        'content'      => $item->content,
                        'goods_id'     => $item->goods_id,
                        'goods_sku_id' => $item->goods_sku_id,
                        'member_id'    => Member::id(),
                        'comment_time' => time(),
                        'image_status' => count($item->upload), // 图片数量大于 0，改变状态
                    ]);

                    // 保存评论图片
                    foreach ($item->upload as $sitem) {
                        if (!$sitem->error) {
                            $comment->images()->create([
                                'image' => $sitem->url
                            ]);
                        }
                    }
                }
                $order->comment_status = self::COMMENT_STATUS_FINISHED;
            }
            $result = $order->save();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 用户取消订单
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public static function close(int $id)
    {
        try {
            $order = self::detail($id);

            if ($order->order_status == self::ORDER_STATUS_CREATED) {
                DB::beginTransaction();
                $order->close_time     = time();
                $order->finish_time    = time();
                $order->order_status   = self::ORDER_STATUS_CLOSED;
                $order->order_progress = self::ORDER_PROGRESS_FINISHED;
                $order->save();
                Event::dispatch(new CloseEvent($order)); // 执行关闭订单事件
                DB::commit();
            }
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 用户删除订单
     * @param int $id
     * @return bool
     */
    public static function remove(int $id)
    {
        $detail = self::detail($id);
        $detail->delete_status = self::DELETE_STATUS_NO;
        return $detail->save();
    }

    public static function verifyPage(int $id)
    {
        return self::detail($id);
    }
}
