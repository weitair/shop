<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Feedback::categorys()
        );
    }

    public function submit()
    {
        $this->validate([
            'category' => 'required|int',
            'contact'  => 'required|string',
            'content'  => 'required|string',
        ]);

        if (Feedback::submit($this->request->all())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
