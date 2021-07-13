<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\AccountLogin;

class LogController extends Controller
{
    public function list()
    {
        $this->renderSuccess(AccountLogin::getList());
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (AccountLogin::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
