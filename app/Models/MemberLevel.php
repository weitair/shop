<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberLevel extends Model
{
    use SoftDeletes;

    protected $table    = 'member_level';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['level_name', 'default', 'sort'];

    // 是否默认(0：否、1：是)
    const DEFAULT_OFF = 0;
    const DEFAULT_ON  = 1;

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    /**
     * 关联到用户
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function member()
    {
        return $this->hasMany(Member::class, 'level_id');
    }
}
