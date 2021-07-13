<?php

namespace App\Http\Controllers\Web\Channel\Wechat;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\WechatFans;

class FansController extends Controller
{
    public function list()
    {
        $this->renderSuccess(WechatFans::getList());
    }

    public function syncSubmit()
    {
        if (WechatFans::getFans() == true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
