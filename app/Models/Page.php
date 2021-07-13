<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $table    = 'page';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['title', 'header', 'content', 'home', 'sort'];

    protected $appends  = ['status_text', 'home_text'];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    // 是否首页(0：否、1：是)
    const HOME_OFF = 0;
    const HOME_ON  = 1;

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_OFF => '禁用',
            self::STATUS_ON  => '启用',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getHomeTextAttribute()
    {
        $status = [
            self::HOME_OFF => '普通页面',
            self::HOME_ON  => '首页',
        ];
        return $status[$this->getAttribute('home')];
    }

    public function getContentAttribute(string $value)
    {
        return json_decode($value, true);
    }

    public function getHeaderAttribute(string $value)
    {
        return json_decode($value, true);
    }
}
