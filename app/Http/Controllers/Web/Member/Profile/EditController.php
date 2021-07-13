<?php

namespace App\Http\Controllers\Web\Member\Profile;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Member;
use App\Logics\Web\MemberTag;

class EditController extends Controller
{
    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Member::select([
                'id',
                'gender',
                'birthday',
                'phone',
                'realname',
                'province',
                'city',
                'district',
            ])->findOrFail($this->request->get('id'))
        );
    }

    public function editSubmit()
    {
        $this->validate([
            'id'    => 'required|int',
            'phone' => 'required|string',
        ]);

        if (Member::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function tag()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'list'   => MemberTag::getAll(),
            'detail' => Member::detail($this->request->get('id')),
        ]);
    }

    public function tagSubmit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Member::editTag($this->request->post())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function tagBatch()
    {
        $this->renderSuccess(MemberTag::getAll());
    }

    public function tagBatchSubmit()
    {
        $this->validate([
            'member' => 'required|string',
            'tag'    => 'required|array',
        ]);

        if (Member::editTagBatch($this->request->post())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function pointBatchSubmit()
    {
        $this->validate([
            'member' => 'required|string',
            'point'  => 'required|int',
            'intro'  => 'required|string',
        ]);

        if (Member::editPointBatch($this->request->post())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
