<?php

namespace App\Logics\Web;

use App\Models\Module as ModuleModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Helper\Tree;
use Log;
use DB;

class Module extends ModuleModel
{
    const PARENT_ERROR = '不能选择自己为上级';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->roleModule()->delete();
        });
    }

    public static function getList()
    {
        $request   = Request::capture();
        $filter    = [];
        $order     = 'sort asc';
        $parent_id = $request->get('parent_id');
        $sort      = $request->get('sort');

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->where('parent_id', $parent_id)
            ->orderByRaw($order)
            ->get();
    }

    public static function getTree(int $selected = -1)
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data, 0, $selected);
    }

    public static function getParentTree()
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data, 0);
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $data['level'] = 0;
        if ($data['parent_id'] > 0) {
            $parent = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 1;
        }

        return (new static($data))->save();
    }

    public static function edit(array $data)
    {
        $data['level'] = 0;
        if ($data['parent_id'] > 0) {
            $parent = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 1;
            // 不能选择自己为上级
            if ($data['parent_id'] == $data['id']) {
                throw new AppException(self::PARENT_ERROR);
            }
        }

        try {
            DB::beginTransaction();
            self::editChildren(self::all(), $data['id'], $data['level']);
            DB::commit();
            return self::detail($data['id'])->fill($data)->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function editChildren($data, int $pid, $level = 0)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $pid) {
                $item->level = $level + 1;
                $item->save();
                self::editChildren($data, $item->id);
            }
        }
    }

    public static function sort(string $id)
    {
        $array = explode(',', $id);

        foreach ($array as $key => $value) {
            self::where(['id' => $value])->update(['sort' => $key]);
        }
        return true;
    }

    public static function remove(int $id)
    {
        try {
            DB::beginTransaction();
            $data = self::all();
            self::removeChildren($data, $id);
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

    public static function removeChildren($data, int $pid)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $pid) {
                self::destroy($item->id);
                self::removeChildren($data, $item->id);
            }
        }
    }
}
