<?php

namespace App\Events\Order;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;

/**
 * 订单签收
 * Class ReceiveEvent
 * @package App\Events\Order
 */
class ReceiveEvent
{
    use SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
