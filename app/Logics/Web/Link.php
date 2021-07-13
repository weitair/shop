<?php

namespace App\Logics\Web;

use App\Models\Link as LinkModel;
use App\Helper\Tree;
use Log;
use DB;

class Link extends LinkModel
{
    public static function getList()
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data);
    }

    /**
     * 用于添加、编辑
     * @param int $id
     * @return array
     */
    public static function getFormList(int $id = 0)
    {
        $data = self::orderBy('sort', 'asc')->get();
        return Tree::make($data, 0, $id);
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
