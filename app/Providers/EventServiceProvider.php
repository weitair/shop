<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // 登录
        'App\Events\Account\LoginFailEvent' => [
            'App\Listeners\Account\LoginFailEventBase',
        ],
        'App\Events\Account\LoginSuccessEvent' => [
            'App\Listeners\Account\LoginSuccessEventBase',
        ],
        // 进入App
        'App\Events\App\EntryEvent' => [
            'App\Listeners\App\EntryEventBase',
        ],
        // 客户
        'App\Events\Member\RegisterEvent' => [
            'App\Listeners\Member\RegisterEventBase',
        ],
        'App\Events\Member\WeappEvent' => [
            'App\Listeners\Member\WeappEventUpdate',
        ],
        'App\Events\Member\WechatEvent' => [
            'App\Listeners\Member\WechatEventUpdate',
        ],
        'App\Events\Member\LoginEvent' => [
            'App\Listeners\Member\LoginEventBase',
        ],
        // 商品
        'App\Events\Goods\ViewEvent' => [
            'App\Listeners\Goods\ViewEventCount',
            'App\Listeners\Goods\ViewEventHistory',
        ],
        // 订单
        'App\Events\Order\CreateEvent' => [
            'App\Listeners\Order\CreateEventBase',
            'App\Listeners\Order\CreateEventGoods',
            'App\Listeners\Order\CreateEventLogistics',
            'App\Listeners\Order\CreateEventLogisticsExpress',
            'App\Listeners\Order\CreateEventLogisticsLocal',
            'App\Listeners\Order\CreateEventLogisticsFetch',
            'App\Listeners\Order\CreateEventCoupon',
            'App\Listeners\Order\CreateEventInvoice',
            'App\Listeners\Order\CreateEventFreeship',
        ],
        'App\Events\Order\SubmitEvent' => [
            'App\Listeners\Order\SubmitEventBase',
            'App\Listeners\Order\SubmitEventCoupon',
        ],
        'App\Events\Order\ShipmentEvent' => [
            'App\Listeners\Order\ShipmentEventMessage',
        ],
        'App\Events\Order\ReceiveEvent' => [
            'App\Listeners\Order\ReceiveEventBase',
            'App\Listeners\Order\ReceiveEventFenxiao',
        ],
        'App\Events\Order\VerifyEvent' => [
            'App\Listeners\Order\VerifyEventBase',
            'App\Listeners\Order\VerifyEventMessage',
        ],
        'App\Events\Order\CloseEvent' => [
            'App\Listeners\Order\CloseEventGoods',
            'App\Listeners\Order\CloseEventCoupon',
        ],
        'App\Events\Order\FinishEvent' => [
            'App\Listeners\Order\FinishEventFenxiao',
        ],
        // 支付
        'App\Events\Payment\SuccessEvent' => [
            'App\Listeners\Payment\SuccessEventBase',
            'App\Listeners\Payment\SuccessEventMessage',
            'App\Listeners\Payment\SuccessEventPrints',
            'App\Listeners\Payment\SuccessEventFenxiao',
        ],
        // 积分
        'App\Events\Point\ChangeEvent' => [
            'App\Listeners\Point\ChangeEventBase',
        ],
        // 成长值
//        'App\Events\Growth\ChangeEvent' => [
//            'App\Listeners\Growth\ChangeEventBase',
//        ],
    ];

    protected $subscribe = [];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
