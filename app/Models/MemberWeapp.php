<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberWeapp extends Model
{
    use SoftDeletes;

    protected $table   = 'member_weapp';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];
}
