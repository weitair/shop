<?php

namespace App\Logics\Api;

use App\Models\OrderVerify as OrderVerifyModel;
use Illuminate\Database\Eloquent\Builder;
use App\Events\Order\VerifyEvent;
use App\Exceptions\AppException;
use App\Models\StoreEmployee;
use App\Models\OrderFetch;
use Event;
use Log;
use DB;

class OrderVerify extends OrderVerifyModel
{
    public static function search(string $code)
    {
        $employee = StoreEmployee::where('member_id', Member::id())->where('verifier', StoreEmployee::VERIFIER_ON)->first();

        if (empty($employee)) {
            throw new AppException('无权核销');
        }

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
            $employee = StoreEmployee::where('member_id', Member::id())->where('verifier', StoreEmployee::VERIFIER_ON)->first();
            if (empty($employee)) {
                throw new AppException('无权核销');
            }

            $order = Order::whereHas('fetch', function (Builder $query) use ($code) {
                return $query->where('verify_code', $code)
                    ->where('fetch_status', OrderFetch::FETCH_STATUS_AWAIT);
            })
                ->with(['fetch', 'goods', 'member'])
                ->where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                ->first();

            if ($order) {
                // 记录核销记录
                $model = new static;
                $model->verifier    = $employee->name;
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
