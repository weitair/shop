<?php

namespace App\Logics\Web;

use App\Models\Assets as AssetsModel;
use Illuminate\Http\Request;

class Assets extends AssetsModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $name    = $request->get('name');

        if (!empty($name)) {
            $filter[] = ['name', 'like', "%$name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with('group', 'account')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
