<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\OrderInvoice;

class InvoiceController extends Controller
{
    public function list()
    {
        $this->renderSuccess(OrderInvoice::getList());
    }

    public function make()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            OrderInvoice::detail($this->request->get('id'))
        );
    }

    public function makeSubmit()
    {
        $this->validate([
            'id'     => 'required|int',
            'tax'    => 'required|numeric',
            'status' => 'required|numeric',
        ]);

        if (OrderInvoice::make($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
