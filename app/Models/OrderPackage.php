<?php

namespace App\Models;

class OrderPackage extends Model
{
    protected $table      = 'order_package';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['channel_text'];

    protected $attributes = ['channel' => 0];

    protected $guarded    = ['order_id'];

    // 配送渠道(0：商家配送、1：第三方配送)
    const CHANNEL_SELF  = 0;
    const CHANNEL_OTHER = 1;

    public function getChannelTextAttribute()
    {
        $status = [
            self::CHANNEL_SELF  => '商家配送',
            self::CHANNEL_OTHER => '第三方配送',
        ];
        return $status[$this->getAttribute('channel')];
    }

    /**
     * 关联订单包裹明细表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function item()
    {
        return $this->hasMany(OrderPackageItem::class, 'package_id');
    }

    public function express()
    {
        return $this->belongsTo(Express::class);
    }
}
