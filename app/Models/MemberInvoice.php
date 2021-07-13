<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberInvoice extends Model
{
    use SoftDeletes;

    protected $table   = 'member_invoice';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    // 发票抬头(0：个人、1：单位)
    const CATEGORY_PERSON  = 0;
    const CATEGORY_COMPANY = 1;
}
