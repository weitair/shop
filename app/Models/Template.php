<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use SoftDeletes;

    protected $table      = 'template';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['method_text'];

    protected $attributes = ['method' => 0];

    protected $fillable   = ['name', 'method', 'sort'];

    // 计价方式(10：按数量、20：按重量)
    const METHOD_QUANTITY = 0;
    const METHOD_WEIGHT   = 1;

    public function getMethodTextAttribute()
    {
        $status = [
            self::METHOD_QUANTITY => '按数量',
            self::METHOD_WEIGHT   => '按重量',
        ];
        return $status[$this->getAttribute('method')];
    }

    public function item()
    {
        return $this->hasMany(TemplateItem::class);
    }

    /**
     * 反向关联到商品表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
