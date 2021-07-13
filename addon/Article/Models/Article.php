<?php

namespace Addon\Article\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Model;

class Article extends Model
{
    use SoftDeletes;

    protected $table    = 'article';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends  = ['best_status_text'];

    protected $fillable = [
        'category_id',
        'title',
        'subtitle',
        'image',
        'style',
        'views',
        'best_status',
        'status',
        'content',
        'publish_time',
    ];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    // 是否推荐(0：否、1：是)
    const BEST_STATUS_OFF = 0;
    const BEST_STATUS_NO  = 1;

    public function getBestStatusTextAttribute()
    {
        $status = [
            self::BEST_STATUS_OFF => '否',
            self::BEST_STATUS_NO  => '是',
        ];
        return $status[$this->getAttribute('best_status')];
    }

    public function getPublishTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d", $value) : '';
    }

    public function getContentAttribute(string $value)
    {
        return urldecode($value);
    }

    public function setContentAttribute(string $value)
    {
        $this->attributes['content'] = urlencode($value);
    }

    /**
     * 关联到分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }
}
