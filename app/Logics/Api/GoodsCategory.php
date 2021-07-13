<?php

namespace App\Logics\Api;

use App\Models\GoodsCategory as GoodsCategoryModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Helper\Tree;

class GoodsCategory extends GoodsCategoryModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function getList()
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data);
    }

    public static function getGoodsList(int $category_id)
    {
        $request  = Request::capture();
        return Goods::whereHas('category', function (Builder $query) use ($category_id) {
            $query->where('category_id', $category_id);
        })
            ->orderBy('sort', 'asc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }
}
