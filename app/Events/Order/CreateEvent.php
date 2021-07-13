<?php

namespace App\Events\Order;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class CreateEvent
{
    use Dispatchable, SerializesModels;

    public $order;

    public $params;

    public $setting;

    public function __construct(Order $order, array $params = [], array $setting = [])
    {
        $this->order = $order;
        $this->params = $params;
        $this->setting = $setting;
    }
}
