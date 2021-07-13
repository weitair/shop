<?php

namespace App\Models;

class OrderFetch extends Model
{
    protected $table      = 'order_fetch';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['fetch_status_text'];

    protected $attributes = ['fetch_status' => 0];

    protected $guarded    = ['order_id'];

    // 提货状态(0：未提货、1：已提货)
    const FETCH_STATUS_AWAIT  = 0;
    const FETCH_STATUS_FINISH = 1;

    public function getFetchStatusTextAttribute()
    {
        $status = [
            self::FETCH_STATUS_AWAIT  => '未提货',
            self::FETCH_STATUS_FINISH => '已提货',
        ];
        return $status[$this->getAttribute('fetch_status')];
    }

    public function getFetchTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
