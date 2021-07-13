<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Search;

class SearchController extends Controller
{
    public function search()
    {
        $this->validate([
            'keyword' => 'required|string',
        ]);

        Search::search($this->request->post('keyword'));
        $this->renderSuccess();
    }

    public function clear()
    {
        if (Search::clear()) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function history()
    {
        $this->renderSuccess(
            Search::history()
        );
    }
}
