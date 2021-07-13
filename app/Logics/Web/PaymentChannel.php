<?php

namespace App\Logics\Web;

use App\Models\PaymentChannel as PaymentChannelModel;
use File;
use Log;
use DB;

class PaymentChannel extends PaymentChannelModel
{
    public static function getList()
    {
        return self::orderBy('sort', 'asc')->get();
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function wechat(array $data)
    {
        try {
            if (!empty($data['apiclient_cert']) && !empty($data['apiclient_key'])) {
                $path = base_path('cert/wechat');

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0644, true);
                }
                File::put($path . '/apiclient_cert.pem', $data['apiclient_cert']);
                File::put($path . '/apiclient_key.pem', $data['apiclient_key']);
            }
            DB::beginTransaction();
            $detail = self::detail(10000);
            $array  = [
                'mch_id'          => $data['mch_id'],
                'mch_key'         => $data['mch_key'],
            ];
            $detail->value = json_encode($array);
            $result = $detail->save();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
