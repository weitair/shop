<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Growth extends Model
{
    use SoftDeletes;

    protected $table   = 'growth';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    // 成长值奖励来源
    const FROM_REGISTER = '新用户注册奖励';
    const FROM_CHECKIN  = '签到打卡奖励';
    const FROM_ORDER    = '购买商品奖励';
    const FROM_SYSTEM   = '系统调整';

    // 状态(0：收入、1：支出)
    const TYPE_INCOME   = 0;
    const TYPE_EXPENSES = 1;

    public function getChangeTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }
}
