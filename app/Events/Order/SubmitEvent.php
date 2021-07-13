<?php

namespace App\Events\Order;

use App\Models\Order;
use Illuminate\Queue\SerializesModels;

/**
 * 提交订单
 * Class SubmitEvent
 * @package App\Events\Order
 */
class SubmitEvent
{
    use SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
