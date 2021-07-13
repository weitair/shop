<?php

namespace App\Http\Controllers\Web\Finance;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Payment;

class PaymentController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Payment::getList());
    }
}
