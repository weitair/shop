<?php

namespace App\Http\Controllers\Web\Member\Profile;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Member;
use App\Logics\Web\MemberTag;

class ProfileController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'tag'  => MemberTag::getAll(),
            'list' => Member::getList(),
        ]);
    }

    public function list()
    {
        $this->renderSuccess(Member::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $detail = Member::detail($this->request->get('id'));
        $this->renderSuccess($detail);
    }

    public function order()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Member::orderList($this->request->get('id'))
        );
    }

    public function comment()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Member::commentList($this->request->get('id'))
        );
    }

    public function point()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(Member::pointList($this->request->get('id')));
    }

    public function address()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(Member::addressList($this->request->get('id')));
    }
}
