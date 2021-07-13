<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class Controller extends BaseController
{
    protected $request;

    public function __construct()
    {
        $this->request = Request::capture();
    }

    public function validate(array $rules)
    {
        $requests  = $this->request->all();
        $validator = Validator::make($requests, $rules);

        if ($validator->fails()) {
            $this->renderError([], $validator->messages()->first());
        }
    }

    public function customValidate(array $requests, array $rules)
    {
        $validator = Validator::make($requests, $rules);

        if ($validator->fails()) {
            $this->renderError([], $validator->messages()->first());
        }
    }

    private function result($data, int $code = 0, string $msg = '')
    {
        $result = [
            'data' => $data,
            'code' => $code,
            'msg'  => $msg,
            'time' => $this->request->server('REQUEST_TIME')
        ];

        Response::create($result, 200, [
            'Content-Type' => 'application/json'
        ])->send();

        die();
    }

    protected function renderSuccess($data = [], string $msg = 'Success', int $code = 0)
    {
        $this->result($data, $code, $msg);
    }

    protected function renderError($data = [], string $msg = 'Error', int $code = 10000)
    {
        $this->result($data, $code, $msg);
    }
}
