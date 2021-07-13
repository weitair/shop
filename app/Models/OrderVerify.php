<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderVerify extends Model
{
    use SoftDeletes;

    protected $table    = 'order_verify';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded  = ['order_id'];

    public function getVerifyTimeAttribute($value)
    {
        return date("Y-m-d H:i:s", $value);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
