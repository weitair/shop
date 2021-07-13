<?php

namespace App\Logics\Web;

use App\Models\MemberTag as MemberTagModel;
use Illuminate\Http\Request;
use Log;
use DB;

class MemberTag extends MemberTagModel
{
    public static function getList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'sort asc';
        $tag_name = $request->get('name');
        $sort     = $request->get('sort');

        if (!empty($tag_name)) {
            $filter[] = ['tag_name', 'like', "%$tag_name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::withCount('member')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getAll()
    {
        return self::select('id', 'tag_name')
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
            DB::beginTransaction();
            $model = self::detail($id);
            $model->member()->detach();
            $model->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
