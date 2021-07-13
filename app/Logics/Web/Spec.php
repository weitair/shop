<?php

namespace App\Logics\Web;

use App\Models\Spec as SpecModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use DB;
use Log;

class Spec extends SpecModel
{
    const FIND_DATA = '该记录下包含了一个或多个商品，不允许删除';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->value()->delete();
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'sort asc';
        $name    = $request->get('name');
        $sort    = $request->get('sort');

        if (!empty($name)) {
            $filter[] = ['name', 'like', "%$name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with(['value' => function ($query) {
            $query->withCount('skuValue');
        }])
            ->withCount('skuValue')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::with(['value'])
            ->orderBy('sort', 'asc')
            ->get();
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

    public static function remove(int $id)
    {
        try {
            $model = self::detail($id);
            if ($model->skuValue()->count() > 0) {
                throw new AppException(self::FIND_DATA);
            }
            DB::beginTransaction();
            $result = self::destroy($id) >= 0;
            DB::commit();
            return $result;
        } catch (AppException $e) {
            throw new AppException($e->getMessage());
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function addValue(array $data)
    {
        return SpecValue::firstOrCreate(
            ['spec_id' => $data['spec_id'], 'name' => $data['name']],
            ['spec_id' => $data['spec_id'], 'name' => $data['name']]
        );
    }

    public static function removeValue(int $id)
    {
        $model = SpecValue::detail($id);
        if ($model->skuValue()->count() > 0) {
            throw new AppException(self::FIND_DATA);
        }
        return $model->delete();
    }
}
