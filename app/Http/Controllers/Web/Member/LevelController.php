<?php

namespace App\Http\Controllers\Web\Member;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\MemberLevel;

class LevelController extends Controller
{
    public function list()
    {
        $this->renderSuccess(
            MemberLevel::getList()
        );
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => MemberLevel::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'level_name' => 'required|string',
        ]);

        if (MemberLevel::add($this->request->all())) {
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
            MemberLevel::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id' => 'required|int',
            'level_name' => 'required|string',
        ]);

        if (MemberLevel::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
