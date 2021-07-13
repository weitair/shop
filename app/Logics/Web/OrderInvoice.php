<?php

namespace App\Logics\Web;

use App\Models\OrderInvoice as OrderInvoiceModel;
use Illuminate\Http\Request;

class OrderInvoice extends OrderInvoiceModel
{
    public static function getList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id desc';
        $status   = $request->get('status', self::STATUS_FINISH);
        $category = $request->get('category');
        $title    = $request->get('title');
        $sort     = $request->get('sort');

        if (is_numeric($status)) {
            $filter[] = ['status', '=', $status];
        }
        if (is_numeric($category)) {
            $filter[] = ['category', '=', $category];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with('order')
            ->where($filter)
            ->when($title, function ($query, $title) {
                $query->where(function ($query) use ($title) {
                    $query->where('name', 'like', "%$title%")->orWhere('company', 'like', "%$title%");
                });
            })
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with('order')->where('order_id', $id)->first();
    }

    public static function make(array $data)
    {
        $detail                 = self::findOrFail($data['id']);
        $detail->tax            = $data['tax'];
        $detail->code           = $data['code'];
        $detail->invoicing_time = time();
        $detail->status         = self::STATUS_FINISH;
        return $detail->save();
    }
}
