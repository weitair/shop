<?php

namespace App\Listeners\Order;

use App\Events\Order\CreateEvent;
use App\Logics\Api\MemberInvoice;
use App\Models\Order;
use App\Models\OrderInvoice;

/**
 * 发票信息
 */
class CreateEventInvoice
{
    public function handle(CreateEvent $event)
    {
        $order = $event->order;

        // 是否开具发票
        if ($order->invoice_status == Order::INVOICE_STATUS_NEED) {
            $invoice                      = MemberInvoice::detail();
            $order->invoice               = new OrderInvoice;
            $order->invoice->member_id    = $invoice->member_id;
            $order->invoice->category     = $invoice->category;
            $order->invoice->name         = $invoice->name;
            $order->invoice->company      = $invoice->company;
            $order->invoice->tax_no       = $invoice->tax_no;
            $order->invoice->bank_name    = $invoice->bank_name;
            $order->invoice->bank_account = $invoice->bank_account;
            $order->invoice->phone        = $invoice->phone;
            $order->invoice->email        = $invoice->email;
        }
    }
}
