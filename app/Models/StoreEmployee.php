<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreEmployee extends Model
{
    use SoftDeletes;

    protected $table      = 'store_employee';

    protected $attributes = ['order' => 0, 'verifier' => 0, 'delivery' => 0];

    protected $guarded    = ['order', 'verifier', 'delivery'];

    // 是否接单员(0：否、1：是)
    const ORDER_OFF = 0;
    const ORDER_ON  = 1;

    // 是否核销员(0：否、1：是)
    const VERIFIER_OFF = 0;
    const VERIFIER_ON  = 1;

    // 是否配送员(0：否、1：是)
    const DELIVERY_OFF = 0;
    const DELIVERY_ON  = 1;

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 接单员列表
     * @return mixed
     */
    public static function orderList()
    {
        return self::where('status', self::STATUS_ON)
            ->where('order', self::ORDER_ON)
            ->get();
    }

    /**
     * 配送员
     * @return mixed
     */
    public static function deliveryList()
    {
        return self::where('status', self::STATUS_ON)
            ->where('delivery', self::DELIVERY_ON)
            ->get();
    }

    /**
     * 核销员
     * @return mixed
     */
    public static function verifyList()
    {
        return self::where('status', self::STATUS_ON)
            ->where('verifier', self::VERIFIER_ON)
            ->get();
    }
}
