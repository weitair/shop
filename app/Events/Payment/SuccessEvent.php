<?php

namespace App\Events\Payment;

use App\Logics\Api\Payment;
use Illuminate\Queue\SerializesModels;

class SuccessEvent
{
    use SerializesModels;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
}
