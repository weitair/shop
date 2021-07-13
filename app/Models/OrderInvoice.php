<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderInvoice extends Model
{
    use SoftDeletes;

    protected $table      = 'order_invoice';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['status_text', 'category_text'];

    protected $attributes = ['status' => 0, 'category' => 0];

    protected $guarded    = ['order_id'];

    // 处理状态(0：待开票、1：已开票)
    const STATUS_AWAIT  = 0;
    const STATUS_FINISH = 1;

    // 发票类型(0：个人、1：单位)
    const CATEGORY_PERSONAL = 0;
    const CATEGORY_COMPANY  = 1;

    public function getTaxAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setTaxAttribute(float $value)
    {
        $this->attributes['tax'] = bcmul($value, 100);
    }

    public function getInvoicingTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_AWAIT  => '待开票',
            self::STATUS_FINISH => '已开票',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getCategoryTextAttribute()
    {
        $status = [
            self::CATEGORY_PERSONAL => '个人',
            self::CATEGORY_COMPANY  => '单位',
        ];
        return $status[$this->getAttribute('category')];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
