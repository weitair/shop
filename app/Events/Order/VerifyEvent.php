<?php

namespace App\Events\Order;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\OrderVerify;
use App\Models\Order;

class VerifyEvent
{
    use Dispatchable, SerializesModels;

    public $order;
    public $verify;

    public function __construct(Order $order, OrderVerify $verify)
    {
        $this->order  = $order;
        $this->verify = $verify;
    }
}
