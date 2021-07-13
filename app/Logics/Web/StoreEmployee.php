<?php

namespace App\Logics\Web;

use App\Models\StoreEmployee as StoreEmployeeModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;

class StoreEmployee extends StoreEmployeeModel
{
    const MEMBER_EXIST  = '该用户已经绑定过了';

    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $name    = $request->get('name');
        $phone   = $request->get('phone');

        if (!empty($name)) {
            $filter[] = ['name', 'like', "%$name%"];
        }
        if (!empty($phone)) {
            $filter[] = ['phone', 'like', "%$phone%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with('member')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with('member')->findOrFail($id);
    }

    public static function add(array $data)
    {
        if (self::where('member_id', $data['member_id'])->first()) {
            throw new AppException(self::MEMBER_EXIST);
        }
        $model = new static($data);
        $model->order    = $data['order'];
        $model->verifier = $data['verifier'];
        $model->delivery = $data['delivery'];
        return $model->save();
    }

    public static function edit(array $data)
    {
        $model = self::where([
            ['id', '<>', $data['id']],
            ['member_id', '=', $data['member_id'] ]
        ])->first();

        if ($model) {
            throw new AppException(self::MEMBER_EXIST);
        }

        $model = self::detail($data['id']);
        $model->fill($data);
        $model->order    = $data['order'];
        $model->verifier = $data['verifier'];
        $model->delivery = $data['delivery'];
        return $model->save();
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
