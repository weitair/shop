<?php

namespace Addon\Coupon\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponGoods extends Model
{
    use SoftDeletes;

    protected $table = 'coupon_goods';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];
}
