<?php

namespace App\Logics\Web;

use App\Models\AssetsGroup as AssetsGroupModel;
use Illuminate\Http\Request;

class AssetsGroup extends AssetsGroupModel
{
    public static function getList()
    {
        $request    = Request::capture();
        $filter     = [];
        $order      = 'sort asc';
        $group_name = $request->get('name');
        $sort       = $request->get('sort');

        if (!empty($group_name)) {
            $filter[] = ['group_name', 'like', "%$group_name%"];
        }
        if (!empty($category_name)) {
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

    public static function remove(string $id)
    {
        $id = explode(',', $id);
        Assets::whereIn('group_id', $id)->update(['group_id' => 0]);
        return self::destroy($id) > 0;
    }
}
