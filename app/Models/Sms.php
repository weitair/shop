<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use SoftDeletes;

    protected $table = 'sms';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'phone',
        'code',
        'send_time',
        'type',
    ];

    // 发送状态(0：失败、1：成功)
    const STATUS_FAIL    = 0;
    const STATUS_SUCCESS = 1;

    // 短信类型(0：验证码、1：短信通知)
    const TYPE_CODE   = 0;
    const TYPE_NOTICE = 1;

    // 使用状态(0：未使用、1：已使用)
    const UNUSED = 0;
    const USED   = 1;

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_FAIL    => '失败',
            self::STATUS_SUCCESS => '成功',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getTypeTextAttribute()
    {
        $status = [
            self::TYPE_CODE   => '验证码',
            self::TYPE_NOTICE => '短信通知',
        ];
        return $status[$this->getAttribute('type')];
    }
}
