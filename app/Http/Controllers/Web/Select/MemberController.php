<?php

namespace App\Http\Controllers\Web\Select;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Select;

class MemberController extends Controller
{
    public function list()
    {
        $this->renderSuccess(Select::memberList());
    }
}
