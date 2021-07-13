<?php

namespace Addon\Coupon\Logics\Api;

use Addon\Coupon\Models\Coupon as CouponModel;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Logics\Api\Member;

class Coupon extends CouponModel
{
    const RECEIVE_LIMIT  = '只能领取这么多了';
    const RECEIVE_FINISH = '这张优惠卷已被领完了';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_START]);
        });

        static::addGlobalScope('coupon_visible', function (Builder $builder) {
            $builder->where('coupon_visible', 1);
        });
    }

    public static function getList()
    {
        $request = Request::capture();

        return self::where('expire_type', self::EXPIRE_TYPE_DYNAMIC)
            ->orWhere(function ($query) {
                $query->where('expire_type', self::EXPIRE_TYPE_FIXED)->where('end_time', '>', time());
            })
            ->orderBy('amount', 'desc')
            ->orderBy('discount', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail($id)
    {
        return self::findOrFail($id);
    }

    /**
     * 领取优惠卷
     * @param int $id
     * @return bool
     * @throws AppException
     */
    public static function received(int $id)
    {
        $count = CouponReceive::where([
            'member_id' => Member::id(),
            'coupon_id' => $id
        ])->count();

        $coupon = self::detail($id);
        if ($coupon->total != 0) {
            // 已领完
            if ($coupon->received >= $coupon->total) {
                throw new AppException(self::RECEIVE_FINISH);
            }
        }

        // 用户领取上限
        if ($count >= $coupon->receive_limit) {
            throw new AppException(self::RECEIVE_LIMIT);
        }
        return CouponReceive::assign($coupon, Member::id(), CouponReceive::SOURCE_RECEIVE);
    }

    /**
     * 我的优惠卷
     * @return mixed
     */
    public static function mineList()
    {
        $request = Request::capture();

        $status  = $request->get('status');
        $filter  = [];

        switch ($status) {
            case '0':
                $filter[] = ['expire_time', '>', time()];
                $filter[] = ['status', '=', CouponReceive::STATUS_UNUSED];
                break;
            case '1':
                $filter[] = ['status', '=', CouponReceive::STATUS_USED];
                break;
            case '2':
                $filter[] = ['expire_time', '<', time()];
                $filter[] = ['status', '=', CouponReceive::STATUS_UNUSED];
                break;
        }

        return CouponReceive::where('member_id', Member::id())
            ->where($filter)
            ->orderBy('expire_time', 'asc')
            ->orderBy('amount', 'desc')
            ->orderBy('discount', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }
}
