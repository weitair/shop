<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;
use App\Logics\Api\StoreAddress;
use App\Logics\Api\Member;
use App\Models\Order;
use App\Models\OrderFetch;

/**
 * 自提信息
 */
class CreateEventLogisticsFetch
{
    public function handle(CreateEvent $event)
    {
        $order   = $event->order;
        $params  = $event->params;

        if ($order->logistics_method == Order::LOGISTICS_METHOD_FETCH && !empty($params['store'])) {
            $store = StoreAddress::detail($params['store']);
            $order->fetch                 = new OrderFetch;
            $order->fetch->member_id      = Member::id();
            $order->fetch->contact        = $params['contact'];
            $order->fetch->phone          = $params['phone'];
            $order->fetch->address_name   = $store->address_name;
            $order->fetch->business       = $store->business;
            $order->fetch->business_begin = $store->business_begin;
            $order->fetch->business_end   = $store->business_end;
            $order->fetch->province       = $store->province;
            $order->fetch->city           = $store->city;
            $order->fetch->district       = $store->district;
            $order->fetch->lon            = $store->lon;
            $order->fetch->lat            = $store->lat;
            $order->fetch->detail         = $store->detail;
            $order->fetch->verify_code    = get_random_number(12);
        }
    }
}
