<?php

namespace App\Logics\Web;

use App\Models\ServiceCategory as ServiceCategoryModel;
use Illuminate\Http\Request;

class ServiceCategory extends ServiceCategoryModel
{
    public static function getList()
    {
        $request = Request::capture();
        $category_name = $request->get('category_name');
        $sort = $request->get('sort');

        $filter = [];
        !empty($category_name) && $filter[] = ['category_name', 'like', "%$category_name%"];
        $order = 'sort asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

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
        return (new static($data))
            ->save();
    }

    public static function edit(array $data)
    {
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }

    public static function status(int $id)
    {
        $model = self::detail($id);
        $model->status = $model->status == self::STATUS_OFF ? self::STATUS_ON : self::STATUS_OFF;
        return $model->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}