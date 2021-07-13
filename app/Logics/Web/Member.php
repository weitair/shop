<?php

namespace App\Logics\Web;

use App\Models\Member as MemberModel;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Point\ChangeEvent;
use App\Models\MemberAddress;
use Illuminate\Http\Request;
use Event;
use Log;
use DB;

class Member extends MemberModel
{
    public static function getList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id desc';
        $keyword  = $request->get('keyword');
        $tag      = $request->get('tag');
        $channel  = $request->get('channel');
        $gender   = $request->get('gender');
        $buy      = $request->get('buy');
        $register = $request->get('register');
        $sort     = $request->get('sort');

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        if (is_numeric($channel)) {
            $filter[] = ['channel', $channel];
        }
        if (is_numeric($gender)) {
            $filter[] = ['gender', $gender];
        }

        return self::with(['level'])
            ->with(['invite' => function ($query) {
                $query->select(['id', 'nickname', 'avatar']);
            }])
            ->withCount(['order' => function (Builder $query) {
                $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED);
            }])
            ->withCount(['order as order_payment' => function (Builder $query) {
                $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                    ->select(DB::raw("round(sum(payment_price/100), 2)"));
            }])
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where(function ($query) use ($keyword) {
                    $query->orWhere('nickname', 'like', "%$keyword%")
                        ->orWhere('realname', 'like', "%$keyword%")
                        ->orWhere('phone', 'like', "%$keyword%");
                });
            })
            ->when(is_numeric($tag), function ($query) use ($tag) {
                return $query->whereHas('tag', function ($query) use ($tag) {
                    $query->where('tag_id', $tag);
                });
            })
            ->when(is_array($buy), function ($query) use ($buy) {
                return $query->whereHas('order', function ($query) use ($buy) {
                    $query->whereBetween('order_time', [$buy[0] / 1000, $buy[1] / 1000]);
                });
            })
            ->when(is_array($register), function ($query) use ($register) {
                return $query->whereBetween('register_time', [$register[0] / 1000, $register[1] / 1000]);
            })
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['level', 'tag'])
            ->with(['invite' => function ($query) {
                $query->select(['id', 'nickname', 'avatar']);
            }])
            ->withCount(['order' => function (Builder $query) {
                $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED);
            }])
            ->withCount(['order as order_payment' => function (Builder $query) {
                $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                    ->select(DB::raw("round(sum(payment_price/100), 2)"));
            }])
            ->findOrFail($id);
    }

    /**
     * 用户订单，用于用户详细
     * @param int $id
     * @return mixed
     */
    public static function orderList(int $id)
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id desc';
        $sort     = $request->get('sort');

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return Order::with('goods')
            ->where('member_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户评价，用于用户详细
     * @param int $id
     * @return mixed
     */
    public static function commentList(int $id)
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id desc';
        $sort     = $request->get('sort');

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return OrderComment::with(['order', 'goods', 'images'])
            ->where('member_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 用户积分，用于用户详细
     * @param int $id
     * @return mixed
     */
    public static function pointList(int $id)
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $sort    = $request->get('sort');

        if (!empty($intro)) {
            $filter[] = ['intro', 'like', "%$intro%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return Point::where('member_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 收货地址，用于用户详细
     * @param int $id
     * @return mixed
     */
    public static function addressList(int $id)
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $sort    = $request->get('sort');

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return MemberAddress::where('member_id', $id)
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }


    public static function editTag(array $data)
    {
        try {
            DB::beginTransaction();
            $detail = self::detail($data['id']);
            $detail->tag()->detach();
            $detail->tag()->attach($data['tag']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function editTagBatch(array $data)
    {
        try {
            DB::beginTransaction();
            $list = self::whereIn('id', explode(',', $data['member']))->get();
            foreach ($list as $member) {
                foreach ($data['tag'] as $tag_id) {
                    if (!$member->tag()->where('tag_id', $tag_id)->first()) {
                        $member->tag()->detach($tag_id);
                        $member->tag()->attach($tag_id);
                    }
                }
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

    public static function editPointBatch(array $data)
    {
        try {
            DB::beginTransaction();
            $list = self::whereIn('id', explode(',', $data['member']))->get();
            foreach ($list as $member) {
                Event::dispatch(new ChangeEvent($member, $data['point'], $data['intro']));
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
        $model = self::detail($data['id']);
        return $model->fill($data)->save();
    }
}
