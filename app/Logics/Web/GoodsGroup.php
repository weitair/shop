<?php

namespace App\Logics\Web;

use App\Models\GoodsGroup as GroupModel;
use Illuminate\Http\Request;
use Log;
use DB;

class GoodsGroup extends GroupModel
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->goods()->detach();
        });
    }

    public static function getList()
    {
        $request    = Request::capture();
        $filter     = [];
        $order      = 'sort asc';
        $group_name = $request->get('name');
        $sort       = $request->get('sort');

        if (!empty($group_name)) {
            $filter[] = ['group_name', 'like', "%$group_name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::withCount('goods')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::orderBy('sort', 'asc')->get();
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

    public static function remove(int $id)
    {
        try {
            DB::beginTransaction();
            $result = self::destroy($id) >= 0;
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
