<?php

namespace App\Logics\Api;

use App\Models\Payment as PaymentModel;
use App\Events\Payment\SuccessEvent;
use App\Services\Payment\Factory;
use App\Exceptions\AppException;
use Event;
use Log;
use DB;

class Payment extends PaymentModel
{
    const PAYMENT_STATUS_FINISHED = '订单已支付，请勿重复支付';
    const ORDER_STATUS_CLOSED     = '超时未支付，订单已关闭';
    const PAYMENT_AMOUNT_ERROR    = '支付金额不能为 0';

    /**
     * 订单支付
     * @param Order $order
     * @return mixed
     * @throws AppException
     */
    public static function submit(Order $order)
    {
        if ($order->payment_status == Order::PAYMENT_STATUS_FINISHED) {
            throw new AppException(self::PAYMENT_STATUS_FINISHED);
        }
        if ($order->order_status == Order::ORDER_STATUS_CLOSED) {
            throw new AppException(self::ORDER_STATUS_CLOSED);
        }
        if ($order->payment_price == 0) {
            throw new AppException(self::PAYMENT_AMOUNT_ERROR);
        }

        $model                  = new static;
        $model->openid          = self::getOpenId($order);
        $model->payment_sn      = get_sn();
        $model->payment_time    = time();
        $model->payment_price   = $order->payment_price;
        $model->payment_channel = $order->payment_channel;
        $model->member_id       = $order->member_id;
        $model->order_id        = $order->id;
        $model->channel         = $order->channel;
        $model->client_ip       = get_client_ip();
        $model->status          = self::STATUS_UNPAID;
        $order->payment()->save($model);

        return Factory::getInstance($model->toArray())->payment();
    }

    /**
     * 根据订单来源返回用户openid(小程序的和公众号的)
     * @param Order $order
     * @return mixed
     */
    private static function getOpenId(Order $order)
    {
        if ($order->channel == self::CHANNEL_WECHAT) {
            return $order->member->wechat->openid;
        } elseif ($order->channel == self::CHANNEL_WECHAT_APP) {
            return $order->member->weapp->openid;
        }
        return '';
    }

    /**
     * 微信回调
     * @return mixed
     * @throws \Exception
     */
    public static function notify()
    {
        $object   = Factory::getInstance(['payment_channel' => 'wechat']);
        // 返回给微信服务器的数据 <xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>
        $result   = $object->notify();
        $response = $object->getResponse();

        try {
            DB::beginTransaction();
            if ($payment = self::where('payment_sn', $response->out_trade_no)->first()) {
                if ($payment->status == self::STATUS_UNPAID) {
                    $payment->transaction_id = $response->transaction_id;
                    $payment->status         = self::STATUS_PAID;
                    $payment->response       = json_encode($response);
                    $payment->save();
                    Event::dispatch(new SuccessEvent($payment));
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
        return $result;
    }
}
