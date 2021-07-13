<?php

namespace App\Http\Controllers\Web\System;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Account;
use App\Logics\Web\Role;

class AccountController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Account::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'role' => Role::getAll()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'role_id'  => 'required|int',
            'username' => 'required|string',
            'password' => 'required|min:6|max:20',
            'gender'   => 'required|int',
            'email'    => 'email',
            'phone'    => 'regex:/^1[34578][0-9]{9}$/',
            'disable'  => 'required|int',
        ]);
        if (Account::add($this->request->all()) === true) {
            $this->renderSuccess([], '操作成功');
        }
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $data['detail'] = Account::detail($this->request->get('id'));
        $data['role']   = Role::getAll();
        $this->renderSuccess($data);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'       => 'required|int',
            'username' => 'required|string',
            'password' => 'min:6|max:20',
            'gender'   => 'required|int',
            'email'    => 'email',
            'phone'    => 'regex:/^1[34578][0-9]{9}$/',
            'disable'  => 'required|int',
        ]);
        if (Account::edit($this->request->except([
                'last_login_time', 'last_login_ip', 'url', 'timestamp'
            ])) === true) {
            $this->renderSuccess([], '操作成功');
        }
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Account::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
