<?php

namespace App\Http\Controllers\Web\Member\Feedback;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\FeedbackCategory;

class CategoryController extends Controller
{
    public function list()
    {
        $this->renderSuccess(FeedbackCategory::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => FeedbackCategory::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'category_name' => 'required|string',
            'sort'          => 'required|int',
        ]);

        if (FeedbackCategory::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            FeedbackCategory::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'            => 'required|int',
            'category_name' => 'required|string',
            'sort'          => 'required|int',
        ]);

        if (FeedbackCategory::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sortSubmit()
    {
        $this->validate([
            'id'    => 'required|int',
            'value' => 'required|int',
        ]);

        $id = $this->request->get('id');
        $value = $this->request->get('value');
        if (FeedbackCategory::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (FeedbackCategory::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
