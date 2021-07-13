<?php

namespace App\Logics\Web;

use App\Models\Payment as PaymentModel;
use Illuminate\Http\Request;

class Payment extends PaymentModel
{
    public static function getList()
    {
        $request    = Request::capture();
        $filter     = [];
        $order      = 'id desc';
        $payment_sn = $request->get('sn');
        $status     = $request->get('status');
        $sort       = $request->get('sort');

        if (!empty($payment_sn)) {
            $filter[] = ['payment_sn', 'like', "%$payment_sn%"];
        }
        if (is_numeric($status)) {
            $filter[] = ['status', '=', $status];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with('member', 'order')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['member'])->findOrFail($id);
    }
}
