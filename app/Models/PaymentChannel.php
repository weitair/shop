<?php

namespace App\Models;

class PaymentChannel extends Model
{
    protected $table    = 'payment_channel';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded  = ['id'];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    // 是否默认(0：否、1：是)
    const DEFAULT_OFF = 0;
    const DEFAULT_ON  = 1;
}
