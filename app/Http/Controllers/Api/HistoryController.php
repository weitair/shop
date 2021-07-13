<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\GoodsHistory;

class HistoryController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            GoodsHistory::getList()
        );
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|array',
        ]);

        if ($order = GoodsHistory::remove($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
