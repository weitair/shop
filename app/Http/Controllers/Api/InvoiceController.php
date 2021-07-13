<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\MemberInvoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            MemberInvoice::detail()
        );
    }

    public function save()
    {
        $this->validate([
            'category' => 'required|int',
            'phone'    => 'required|string',
            'email'    => 'required|string',
        ]);

        if ($order = MemberInvoice::submit($this->request->post())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
