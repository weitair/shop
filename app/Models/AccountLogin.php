<?php

namespace App\Models;

class AccountLogin extends Model
{
    protected $table      = 'account_login';

    protected $hidden     = ['account_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['status_text'];

    protected $attributes = ['status' => 0];

    protected $guarded    = ['account_id'];

    // 状态(0：失败、1：成功)
    const STATUS_FAIL    = 0;
    const STATUS_SUCCESS = 1;

    public function getLoginTimeAttribute($value)
    {
        return date("Y-m-d H:i:s", $value);
    }

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_FAIL    => '失败',
            self::STATUS_SUCCESS => '成功',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
