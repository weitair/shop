<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Member;
use App\Logics\Api\MemberAddress;

class AddressController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            MemberAddress::getList()
        );
    }

    public function detail()
    {
        $this->renderSuccess(
            MemberAddress::detail($this->request->get('id'))
        );
    }

    public function add()
    {
        $this->renderSuccess(Member::detail());
    }

    public function save()
    {
        $this->validate([
            'contact'  => 'required|string',
            'phone'    => 'required|string',
            'province' => 'required|string',
            'city'     => 'required|string',
            'district' => 'required|string',
            'detail'   => 'required|string',
            'default'  => 'required|int',
        ]);

        if (MemberAddress::sumbit($this->request->all())) {
            $this->renderSuccess([], '地址保存成功');
        }
        $this->renderError();
    }

    public function saveLocal()
    {
        $this->validate([
            'contact'  => 'required|string',
            'phone'    => 'required|string',
            'detail'   => 'required|string',
            'default'  => 'required|int',
        ]);

        if (MemberAddress::sumbit($this->request->all())) {
            $this->renderSuccess([], '地址保存成功');
        }
        $this->renderError();
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (MemberAddress::remove($this->request->post('id')) === true) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function default()
    {
        $this->renderSuccess(
            MemberAddress::default()
        );
    }
}
