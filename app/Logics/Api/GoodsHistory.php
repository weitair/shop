<?php

namespace App\Logics\Api;

use App\Models\GoodsHistory as GoodsHistoryModel;
use Illuminate\Http\Request;

class GoodsHistory extends GoodsHistoryModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter = ['member_id' => Member::id()];
        $order = 'created_at desc';

        return self::has('goods')
            ->with('goods')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function remove(array $id)
    {
        return self::destroy($id) > 0;
    }
}
