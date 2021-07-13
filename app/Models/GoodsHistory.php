<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsHistory extends Model
{
    use SoftDeletes;

    protected $table   = 'goods_history';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    public function getViewTimeAttribute($value)
    {
        return $value ? date("Y/m/d", $value) : '';
    }

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
