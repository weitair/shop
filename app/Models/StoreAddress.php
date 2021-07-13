<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreAddress extends Model
{
    use SoftDeletes;

    protected $table      = 'store_address';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['status_text'];

    protected $attributes = ['status' => 0];

    protected $fillable   = [
        'address_name',
        'contact',
        'phone',
        'business',
        'business_begin',
        'business_end',
        'province',
        'city',
        'district',
        'lon',
        'lat',
        'detail',
        'sort',
        'status',
        'is_fetch',
        'is_shipment'
    ];

    // 状态(0：休息、1：营业)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    // 营业时间(0：全天、1：自定)
    const BUSINESS_ALL    = 0;
    const BUSINESS_SELECT = 1;

    // 是否自提地址(0：否、1：是)
    const FETCH_OFF = 0;
    const FETCH_ON  = 1;

    // 是否发货地址(0：否、1：是)
    const SHIPMENT_OFF = 0;
    const SHIPMENT_ON  = 1;

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_OFF => '休息',
            self::STATUS_ON  => '营业',
        ];
        return $status[$this->getAttribute('status')];
    }
}
