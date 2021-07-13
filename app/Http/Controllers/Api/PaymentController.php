<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Payment;

class PaymentController extends Controller
{
    /**
     * 微信回调
     */
    public function notify()
    {
        return Payment::notify();
    }
}
