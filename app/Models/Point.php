<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

class Point extends Model
{
    use SoftDeletes;

    protected $table   = 'point';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    // 备注说明
    const INTRO_REGISTER = '新用户注册奖励';
    const INTRO_CHECKIN  = '签到打卡奖励';
    const INTRO_INVITE   = '邀请新用户奖励';
    const INTRO_ORDER    = '购买商品奖励';
    const INTRO_SYSTEM   = '系统调整';

    // 状态(0：收入、1：支出)
    const TYPE_INCOME   = 0;
    const TYPE_EXPENSES = 1;

    public function getTypeTextAttribute()
    {
        $status = [
            self::TYPE_INCOME   => '收入',
            self::TYPE_EXPENSES => '支出',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getChangeTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }
}
