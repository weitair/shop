<?php

namespace App\Http\Controllers\Web\Setting;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Template;

class TemplateController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Template::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'sort' => Template::getMaxSort()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'name'   => 'required|string',
            'method' => 'required|int',
            'sort'   => 'required|int',
        ]);

        if (Template::add($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);
        $detail = Template::detail($this->request->get('id'));
        foreach ($detail->item as $value) {
            $value->region = json_decode($value->region);
        }
        $this->renderSuccess($detail);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'     => 'required|int',
            'name'   => 'required|string',
            'method' => 'required|int',
            'sort'   => 'required|int',
        ]);

        if (Template::edit($this->request->all())) {
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
        if (Template::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Template::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
