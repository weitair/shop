<?php

namespace Addon\Article\Logics\Web;

use Addon\Article\Models\ArticleBanner as ArticleBannerModel;
use Illuminate\Http\Request;

class ArticleBanner extends ArticleBannerModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'sort asc';
        $title   = $request->get('title');
        $sort    = $request->get('sort');

        if (!empty($title)) {
            $filter[] = ['title', 'like', "%$title%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        return (new static($data))->save();
    }

    public static function edit(array $data)
    {
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }

    public static function status(int $id)
    {
        $model         = self::detail($id);
        $model->status = $model->status == self::STATUS_OFF ? self::STATUS_ON : self::STATUS_OFF;
        return $model->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
