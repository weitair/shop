<?php

namespace App\Logics\Web;

use App\Models\GoodsCategory as GoodsCategoryModel;
use App\Exceptions\AppException;
use App\Helper\Tree;
use Log;
use DB;

class GoodsCategory extends GoodsCategoryModel
{
    const LEVEL_MAX    = 3;
    const LEVEL_ERROR  = '最多只能添加三级';
    const PARENT_ERROR = '不能选择自己为上级';

    public static function getList()
    {
        $data = self::withCount('goods')->orderBy('sort', 'asc')->get();
        foreach ($data as $item) {
            $item->disabled = $item->status == self::STATUS_OFF;
        }
        return Tree::make($data, 0);
    }

    /**
     * 用于添加、编辑
     * @param int $id
     * @return array
     */
    public static function getFormList(int $id = 0)
    {
        $data = self::where('level', '<', self::LEVEL_MAX - 1)
            ->orderBy('sort', 'asc')
            ->get();

        return Tree::make($data, 0, $id);
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $data['level'] = 0;
        if ($data['parent_id'] > 0) {
            $parent        = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 1;
        }
        if ($data['level'] >= self::LEVEL_MAX) {
            throw new AppException(self::LEVEL_ERROR);
        }
        return (new static($data))->save();
    }

    public static function edit(array $data)
    {
        $data['level'] = 0;
        if ($data['parent_id'] > 0) {
            $parent        = self::detail($data['parent_id']);
            $data['level'] = $parent->level + 1;
            // 不能选择自己为上级
            if ($data['parent_id'] == $data['id']) {
                throw new AppException(self::PARENT_ERROR);
            }
        }
        if ($data['level'] >= self::LEVEL_MAX) {
            throw new AppException(self::LEVEL_ERROR);
        }

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

    public static function removeChildren(&$data, int $pid)
    {
        foreach ($data as $item) {
            if ($item->parent_id == $pid) {
                self::destroy($item->id);
                self::removeChildren($data, $item->id);
            }
        }
    }
}
