<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\OrderComment;

class CommentController extends Controller
{
    public function list()
    {
        $this->renderSuccess(OrderComment::getList());
    }

    public function auditSubmit()
    {
        $this->validate([
            'id'     => 'required|string',
            'status' => 'required|int',
        ]);

        if (OrderComment::audit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function reply()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        $this->renderSuccess(
            OrderComment::detail($this->request->get('id'))
        );
    }

    public function replySubmit()
    {
        $this->validate([
            'id'    => 'required|int',
            'reply' => 'required|string',
        ]);

        if (OrderComment::reply($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (OrderComment::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
