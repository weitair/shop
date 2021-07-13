<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsSkuValue extends Model
{
    use SoftDeletes;

    protected $table    = 'goods_sku_value';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['goods_sku_id', 'goods_id', 'spec_id', 'spec_value_id', 'app_id'];

    /**
     * 反向关联到规格
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo(Spec::class, 'spec_id');
    }

    /**
     * 反向关联到规格值
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specValue()
    {
        return $this->belongsTo(SpecValue::class, 'spec_value_id');
    }
}
