<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Spec extends Model
{
    use SoftDeletes;

    protected $table    = 'spec';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['name', 'search', 'sort'];

    /**
     * 关联规格值
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function value()
    {
        return $this->hasMany(SpecValue::class);
    }

    /**
     * 关联SKU值
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skuValue()
    {
        return $this->hasMany(GoodsSkuValue::class);
    }
}
