<?php

namespace Addon\Coupon\Logics\Web;

use Addon\Coupon\Models\CouponReceive as CouponReceiveModel;
use Illuminate\Http\Request;

class CouponReceive extends CouponReceiveModel
{
    public static function getList()
    {
        $request     = Request::capture();
        $filter      = [];
        $order       = 'id desc';
        $coupon_name = $request->get('name');
        $coupon_type = $request->get('type');
        $status      = $request->get('status');
        $source      = $request->get('source');
        $sort        = $request->get('sort');

        if (!empty($coupon_name)) {
            $filter[] = ['coupon_name', 'like', "%$coupon_name%"];
        }
        if (is_numeric($coupon_type)) {
            $filter[] = ['coupon_type', '=', $coupon_type];
        }
        if (is_numeric($status)) {
            $filter[] = ['status', '=', $status];
        }
        if (is_numeric($source)) {
            $filter[] = ['source', '=', $source];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with(['member'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
