<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberWechat extends Model
{
    use SoftDeletes;

    protected $table   = 'member_wechat';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];
}
