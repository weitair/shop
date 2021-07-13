<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsFavorite extends Model
{
    use SoftDeletes;

    protected $table   = 'goods_favorite';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['member_id'];

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    public function getAddTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }
}
