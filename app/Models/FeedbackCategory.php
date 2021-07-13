<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FeedbackCategory extends Model
{
    use SoftDeletes;

    protected $table   = 'feedback_category';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];
}
