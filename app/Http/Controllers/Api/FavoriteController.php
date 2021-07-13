<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\GoodsFavorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            GoodsFavorite::getList()
        );
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|array',
        ]);

        if ($order = GoodsFavorite::remove($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
