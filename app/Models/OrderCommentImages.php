<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderCommentImages extends Model
{
    use SoftDeletes;

    protected $table    = 'order_comment_images';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['comment_id'];
}
