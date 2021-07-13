<?php

namespace App\Logics\Api;

use App\Models\Feedback as FeedbackModel;
use App\Models\FeedbackCategory;

class Feedback extends FeedbackModel
{
    public static function categorys()
    {
        return FeedbackCategory::orderBy('sort', 'asc')->get();
    }

    public static function submit(array $data)
    {
        $model = new static;
        $model->category_id   = $data['category'];
        $model->contact       = $data['contact'];
        $model->content       = $data['content'];
        $model->feedback_time = time();
        return $model->save();
    }
}
