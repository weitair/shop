<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    protected $table   = 'feedback';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    public function getFeedbackTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class);
    }
}
