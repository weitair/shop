<?php

namespace App\Logics\Web;

use App\Events\Order\ServiceEvent;
use App\Models\Service as ServiceModel;
use Illuminate\Http\Request;
use Event;
use Log;
use DB;

class Service extends ServiceModel
{
    public static function getList()
    {
        $request = Request::capture();
        $name = $request->get('order_sn');
        $status = $request->get('status');
        $filter = [];
        $filter1 = [];

        !empty($name) && $filter1[] = ['order_sn', 'like', "%$name%"];
        !empty($status) && $filter[] = ['status', '=', $status];
        $order = 'status asc,id desc';

        return self::withTrashed()->whereHas('order', function ($query) use ($filter1) {
            return $query->where($filter1);
        })
            ->with(['order', 'member', 'goods', 'category', 'category'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::withTrashed()->with(['order', 'member', 'goods', 'category'])->findOrFail($id);
    }

    public static function status()
    {
        $request = Request::capture();
        $data = $request->all();
        try {
            DB::beginTransaction();
            $service = self::detail($data['id']);
            $service->status = self::STATUS_FINISHED;
            $service->operate_type = $data['operate_type'];
            !empty($data['operate_reason']) && $service->operate_reason = $data['operate_reason'];
            $service->end_time = time();
            if (isset($data['payment_type'])) {
                $service->payment_type = $data['payment_type'];
            }
            $service->save();
//            Event::dispatch(new ServiceEvent($service));
            DB::commit();
            return 10;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
