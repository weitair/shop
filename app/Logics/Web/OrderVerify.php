<?php

namespace App\Logics\Web;

use App\Models\OrderVerify as OrderVerifyModel;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Order\VerifyEvent;
use Illuminate\Http\Request;
use App\Models\OrderFetch;
use Event;
use Log;
use DB;

class OrderVerify extends OrderVerifyModel
{
    public static function getList()
    {
        $request     = Request::capture();
        $filter      = [];
        $order       = 'id desc';
        $verify_code = $request->get('code');

        if (!empty($verify_code)) {
            $filter[] = ['verify_code', 'like', "%$verify_code%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with('order')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function search(string $code = '')
    {
        return Order::whereHas('fetch', function (Builder $query) use ($code) {
            return $query->where('verify_code', $code);
        })
            ->with(['fetch', 'goods'])
            ->where('payment_status', Order::PAYMENT_STATUS_FINISHED)
            ->first();
    }

    public static function submit(string $code)
    {
        try {
            DB::beginTransaction();
            $order = Order::whereHas('fetch', function (Builder $query) use ($code) {
                return $query->where('verify_code', $code)
                    ->where('fetch_status', OrderFetch::FETCH_STATUS_AWAIT);
            })
                ->with(['fetch', 'goods', 'member'])
                ->where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                ->first();

            if ($order) {
                // 核销记录
                $model = new static;
                $model->verifier    = Account::user()->username;
                $model->verify_code = $code;
                $model->verify_time = time();
                $order->verify()->save($model);

                Event::dispatch(new VerifyEvent($order, $model));
                DB::commit();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
