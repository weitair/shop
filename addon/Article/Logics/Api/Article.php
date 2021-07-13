<?php

namespace Addon\Article\Logics\Api;

use Addon\Article\Models\Article as ArticleModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Article extends ArticleModel
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
        $request = Request::capture();
        $category = $request->get('category');
        $filter[] = empty($category) ? ['best_status', '=', self::BEST_STATUS_NO] : ['category_id', '=', $category];

        return self::where($filter)
            ->orderBy('id', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail($id)
    {
        $detail = self::findOrFail($id);

        $detail->views += 1;
        $detail->save();
        return $detail;
    }
}
