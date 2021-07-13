<?php

namespace App\Logics\Web;

use App\Models\MemberLevel as MemberLevelModel;
use Illuminate\Http\Request;

class MemberLevel extends MemberLevelModel
{
    public static function getList()
    {
        $request     = Request::capture();
        $filter      = [];
        $order       = 'level asc';
        $level_name  = $request->get('name');

        if (!empty($level_name)) {
            $filter[] = ['level_name', 'like', "%$level_name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::withCount('member')
            ->where($filter)
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
}
