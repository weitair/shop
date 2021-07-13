<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $table    = 'service';

    protected $hidden   = [];

    protected $fillable = [];

    // 状态(0：申请中、1：已完成)
    const STATUS_APPLY    = 0;
    const STATUS_FINISHED = 1;

    // 审核状态(0：未通过、1：通过)
    const AUDIT_STATUS_FAIL = 0;
    const AUDIT_STATUS_PASS = 1;

    // 售后类型(0：仅退款、1 ：退货退款)
    const SERVICE_TYPE_REFUND        = 0;
    const SERVICE_TYPE_RETURN_REFUND = 1;

    // 支付类型(0：线上支付、1：手动支付)
    const PAYMENT_CHANNEL_ONLINE  = 0;
    const PAYMENT_CHANNEL_OFFLINE = 1;

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function goods()
    {
        return $this->hasMany(ServiceGoods::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceImages::class);
    }

    public function getBeginTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getEndTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getPaymentPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setPaymentPriceAttribute(float $value)
    {
        $this->attributes['payment_price'] = bcmul($value, 100);
    }

//    public function getServiceType($valeu)
//    {
//        $data = [
//            self::SERVICE_TYPE_ALL=>'退货退款',
//            self::SERVICE_TYPE_REFUND=>'退款'
//        ];
//        return $data[$valeu];
//    }
//
//    public function getOperateType($valeu)
//    {
//        $data = [
//            Self::OPERATE_TYPE_PASS=>'通过',
//            self::SERVICE_TYPE_REJECT=>'驳回',
//            self::SERVICE_TYPE_CANCEL=>'用户已取消'
//        ];
//        return $data[$valeu];
//    }
//
//    public function getPaymenType($valeu)
//    {
//        // 支付类型(10：线上支付、20：手动支付)
//
//        $data = [
//            self::PAYMENT_TYPE_ONLINE=>'线上支付',
//            self::PAYMENT_TYPE_OFFLINE=>'手动支付'
//        ];
//        return $data[$valeu];
//    }
}
