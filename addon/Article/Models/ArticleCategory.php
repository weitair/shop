<?php

namespace Addon\Article\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $table    = 'article_category';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['parent_id', 'category_name', 'sort', 'status', 'level', 'status'];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;
}
