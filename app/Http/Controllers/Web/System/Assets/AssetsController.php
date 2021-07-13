<?php

namespace App\Http\Controllers\Web\System\Assets;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Assets;

class AssetsController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Assets::getList());
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Assets::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
