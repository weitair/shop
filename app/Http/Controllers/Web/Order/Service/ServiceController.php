<?php

namespace App\Http\Controllers\Web\Order\Service;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Service;

class ServiceController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Service::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Service::detail($this->request->get('id'))
        );
    }

    public function status()
    {
        $this->renderSuccess(Service::status());
    }


}
