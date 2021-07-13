<?php

namespace App\Logics\Api;

use App\Models\GoodsFavorite as GoodsFavoriteModel;
use Illuminate\Http\Request;

class GoodsFavorite extends GoodsFavoriteModel
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

    public static function change(int $id)
    {
        $member = Member::user();
        $model  = self::where('member_id', $member->id)->where('goods_id', $id)->first();
        if ($model) {
            return $model->delete();
        } else {
            $model            = new static;
            $model->goods_id  = $id;
            $model->member_id = $member->id;
            $model->add_time  = time();
            return $model->save();
        }
    }

    public static function isFavorite(int $id)
    {
        return self::where([
            'goods_id'  => $id,
            'member_id' => Member::id()
        ])->first() !== null;
    }

    public static function remove(array $id)
    {
        return self::destroy($id) > 0;
    }
}
