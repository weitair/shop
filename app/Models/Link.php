<?php

namespace App\Models;

class Link extends Model
{
    protected $table      = 'link';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['type_text'];

    protected $attributes = ['type' => 0];

    protected $fillable   = ['parent_id', 'name', 'type', 'path', 'sort', 'key'];

    // 类型(0：分组、1：链接)
    const TYPE_GROUP = 0;
    const TYPE_PATH  = 1;

    public function getTypeTextAttribute()
    {
        $status = [
            self::TYPE_GROUP => '分组',
            self::TYPE_PATH  => '链接',
        ];
        return $status[$this->getAttribute('type')];
    }

//    public function parent()
//    {
//        return $this->belongsTo(self::class, 'parent_id');
//    }
}
