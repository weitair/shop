<?php

namespace App\Http\Controllers\Web\Member\Feedback;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Feedback;
use App\Logics\Web\FeedbackCategory;

class FeedbackController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            [
                'category' => FeedbackCategory::getAll(),
                'list'     => Feedback::getList()
            ]
        );
    }

    public function list()
    {
        $this->renderSuccess(Feedback::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Feedback::detail($this->request->get('id'))
        );
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Feedback::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
