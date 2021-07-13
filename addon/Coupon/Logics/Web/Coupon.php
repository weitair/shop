<?php

namespace Addon\Coupon\Logics\Web;

use Addon\Coupon\Models\Coupon as CouponModel;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Models\MemberTag;
use App\Models\Member;
use Log;
use DB;

class Coupon extends CouponModel
{
    const FIND_DATA = '该优惠卷已被用户领取，不允许删除';

    public static function getList()
    {
        $request        = Request::capture();
        $filter         = [];
        $order          = 'id desc';
        $status         = $request->get('status', self::STATUS_START);
        $coupon_name    = $request->get('name');
        $coupon_type    = $request->get('type');
        $coupon_visible = $request->get('visible');
        $sort           = $request->get('sort');

        if (!empty($coupon_name)) {
            $filter[] = ['coupon_name', 'like', "%$coupon_name%"];
        }
        if (is_numeric($coupon_type)) {
            $filter[] = ['coupon_type', '=', $coupon_type];
        }
        if (is_numeric($coupon_visible)) {
            $filter[] = ['coupon_visible', '=', $coupon_visible];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->where('status', $status)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        $detail = self::with(['goods'])->findOrFail($id);
        $detail->tag = MemberTag::whereIn('id', $detail->tag)->get();
        return $detail;
    }

    public static function add(array $data)
    {
        try {
            DB::beginTransaction();
            if ($model = self::create($data)) {
                $model->saveGoods($data);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function edit(array $data)
    {
        try {
            DB::beginTransaction();
            $model = self::detail($data['id']);
            if ($model->fill($data)->save()) {
                $model->saveGoods($data);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    private function saveGoods(array $data)
    {
        if ($data['goods_limit'] != self::GOODS_LIMIT_ALL) {
            $this->goods()->detach();
            $this->goods()->attach($data['goods']);
        }
    }

    public static function pushSubmit(array $data)
    {
        try {
            $member = [];
            if ($data['group'] == self::COUPON_PUSH_SELECT) {
                $member = Member::whereIn('id', $data['member'])->get();
            }
            if ($data['group'] == self::COUPON_PUSH_TAG) {
                $member = Member::whereHas('tag', function (Builder $query) use ($data) {
                    $query->whereIn('tag_id', $data['tag']);
                })->get();
            }
            if ($data['group'] == self::COUPON_PUSH_NEW) {
                $member = Member::news();
            }
            if ($data['group'] == self::COUPON_PUSH_OLD) {
                $member = Member::olds();
            }
            DB::beginTransaction();
            if ($coupon = self::create($data)) {
                $coupon->saveGoods($data);
            }

            foreach ($member as $item) {
                CouponReceive::assign($coupon, $item->id, CouponReceive::SOURCE_PUSH);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function status(int $id)
    {
        $model         = self::detail($id);
        $model->status = self::STATUS_FINISHED;
        return $model->save();
    }

    public static function remove(string $id)
    {
        $model = self::detail($id);
        if ($model->receive()->count() > 0) {
            throw new AppException(self::FIND_DATA);
        }
        return self::destroy($id) >= 0;
    }
}
