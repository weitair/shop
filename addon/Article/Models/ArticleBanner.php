<?php

namespace Addon\Article\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;

class ArticleBanner extends Model
{
    use SoftDeletes;

    protected $table    = 'article_banner';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts    = ['redirect' => 'json'];

    protected $fillable = [
        'title',
        'image',
        'redirect',
        'status',
        'sort',
    ];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;
}
