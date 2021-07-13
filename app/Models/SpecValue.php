<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SpecValue extends Model
{
    use SoftDeletes;

    protected $table    = 'spec_value';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['name', 'sort', 'spec_id'];

    /**
     * 关联SKU值
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skuValue()
    {
        return $this->hasMany(GoodsSkuValue::class);
    }

    /**
     * 反向关联到规格
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }
}
