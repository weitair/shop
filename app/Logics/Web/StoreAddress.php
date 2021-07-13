<?php

namespace App\Logics\Web;

use App\Models\StoreAddress as StoreAddressModel;
use Illuminate\Http\Request;

class StoreAddress extends StoreAddressModel
{
    public static function getList()
    {
        $request      = Request::capture();
        $filter       = [];
        $order        = 'id desc';
        $address_name = $request->get('name');
        $sort         = $request->get('sort');

        if (!empty($address_name)) {
            $filter[] = ['address_name', 'like', "%$address_name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::all(['id', 'address_name']);
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        return (new static($data))->save();
    }

    public static function edit(array $data)
    {
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }

    public static function status(int $id)
    {
        $model         = self::detail($id);
        $model->status = $model->status == self::STATUS_OFF ? self::STATUS_ON : self::STATUS_OFF;
        return $model->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}