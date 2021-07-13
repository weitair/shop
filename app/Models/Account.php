<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $table       = 'account';

    protected $hidden     = ['password', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['disable_text'];

    protected $attributes = ['disable' => 0];

    protected $guarded    = ['role_id'];

    // 是否禁用(0: 未禁用、1：已禁用)
    const DISABLE_OFF = 0;
    const DISABLE_ON  = 1;

    public function getLastLoginTimeAttribute(int $value)
    {
        return !empty($value) ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getDisableTextAttribute()
    {
        $status = [
            self::DISABLE_OFF => '正常',
            self::DISABLE_ON  => '禁用',
        ];
        return $status[$this->getAttribute('disable')];
    }

    /**
     * 关联到角色，用于列表显示
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function loginLog()
    {
        return $this->hasMany(AccountLogin::class);
    }
}
