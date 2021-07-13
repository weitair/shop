<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    protected $table      = 'goods';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded    = ['stock', 'sales', 'views'];

    // 状态(0：仓库中、1：销售中)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;

    // 规格类型(0：单规格、1：多规格)
    const SPEC_TYPE_SINGLE = 0;
    const SPEC_TYPE_MULTI  = 1;

    // 是否统一运费(0：否、1：是)
    const LOGISTICS_UNITE_OFF = 0;
    const LOGISTICS_UNITE_ON  = 1;

    public function setTemplateIdAttribute(string $value)
    {
        $this->attributes['template_id'] = empty($value) ? 0 : $value;
    }

    public function getSalesPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setSalesPriceAttribute(float $value)
    {
        $this->attributes['sales_price'] = bcmul($value, 100);
    }

    public function getLinePriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLinePriceAttribute(float $value)
    {
        $this->attributes['line_price'] = bcmul($value, 100);
    }

    public function setSalesTimeAttribute(string $value)
    {
        $this->attributes['sales_time'] = strtotime($value);
    }

    public function getSalesTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getLogisticsPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLogisticsPriceAttribute(float $value)
    {
        $this->attributes['logistics_price'] = bcmul($value, 100);
    }

    public function getContentAttribute(string $value)
    {
        return urldecode($value);
    }

    public function setContentAttribute(string $value)
    {
        $this->attributes['content'] = urlencode($value);
    }

    /**
     * 关联到分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany(
            GoodsCategory::class,
            'goods_category_pivot',
            'goods_id',
            'category_id'
        )
            ->withPivot('goods_id', 'category_id', 'level')
            ->orderBy('level', 'asc');
    }

    /**
     * 关联分组表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function group()
    {
        return $this->belongsToMany(
            GoodsGroup::class,
            'goods_group_pivot',
            'goods_id',
            'group_id'
        )->where('status', GoodsGroup::STATUS_ON);
    }

    /**
     * 关联支持表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function support()
    {
        return $this->belongsToMany(
            GoodsSupport::class,
            'goods_support_pivot',
            'goods_id',
            'support_id'
        )->where('status', GoodsSupport::STATUS_ON);
    }

    /**
     * 关联商品图片
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(GoodsImages::class);
    }

    /**
     * 关联Sku
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sku()
    {
        return $this->hasMany(GoodsSku::class, 'goods_id');
    }

    /**
     * 关联SkuValue
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skuValue()
    {
        return $this->hasMany(GoodsSkuValue::class);
    }

    /**
     * 多对多关联到规格表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spec()
    {
        return $this->belongsToMany(
            Spec::class,
            'goods_sku_value',
            'goods_id',
            'spec_id'
        )->wherePivot('deleted_at', null);
    }

    /**
     * 多对多关联到规格值表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specValue()
    {
        return $this->belongsToMany(
            SpecValue::class,
            'goods_sku_value',
            'goods_id',
            'spec_value_id'
        )->wherePivot('deleted_at', null);
    }

    /**
     * 关联商品的评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class);
    }

    /**
     * 关联用户浏览历史
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(GoodsHistory::class);
    }

    /**
     * 关联用户收藏
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite()
    {
        return $this->hasMany(GoodsFavorite::class);
    }
}
