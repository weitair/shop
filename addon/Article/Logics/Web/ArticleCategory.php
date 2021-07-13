<?php

namespace Addon\Article\Logics\Web;

use Addon\Article\Models\ArticleCategory as ArticleCategoryModel;
use Illuminate\Http\Request;
use DB;
use Log;

class ArticleCategory extends ArticleCategoryModel
{
    public static function getList()
    {
        $request       = Request::capture();
        $filter        = [];
        $order         = 'sort asc';
        $category_name = $request->get('category_name');
        $sort          = $request->get('sort');

        if (!empty($category_name)) {
            $filter[] = ['category_name', 'like', "%$category_name%"];
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

    public static function getAll()
    {
        return self::orderBy('sort', 'asc')->get();
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
        try {
            DB::beginTransaction();
            $data = self::all();
            self::removeChildren($data, $id);
            $result = self::destroy($id) >= 0;
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function removeChildren(&$data, int $pid)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $pid) {
                self::destroy($item->id);
                self::removeChildren($data, $item->id);
            }
        }
    }
}
