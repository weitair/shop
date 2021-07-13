<?php

namespace App\Http\Controllers\Web\Member;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\MemberTag;

class TagController extends Controller
{
    public function list()
    {
        $this->renderSuccess(MemberTag::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => MemberTag::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'tag_name' => 'required|string',
            'sort'     => 'required|int',
        ]);

        if (MemberTag::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        $this->renderSuccess(
            MemberTag::detail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'       => 'required|int',
            'tag_name' => 'required|string',
            'sort'     => 'required|int',
        ]);

        if (MemberTag::edit($this->request->all())) {
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
        if (MemberTag::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (MemberTag::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
