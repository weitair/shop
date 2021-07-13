<?php

namespace App\Logics\Web;

use App\Models\Role as RoleModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use DB;
use Log;

class Role extends RoleModel
{
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
        $order     = 'id asc';
        $role_name = $request->get('name');
        $sort      = $request->get('sort');

        if (!empty($role_name)) {
            $filter[] = ['role_name', '=', $role_name];
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
        return self::all(['id', 'role_name']);
    }

    public static function detail(int $id)
    {
        return self::with('roleModule')->findOrFail($id);
    }

    /**
     * @param array $data 角色数据
     * @param string $module 模块数据
     * @return bool
     * @throws \Exception
     */
    public static function add(array $data, string $module)
    {
        try {
            DB::beginTransaction();
            if ($model = self::create($data)) {
                $model->saveModule($module);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * @param array $data
     * @param string $module
     * @return bool
     * @throws \Exception
     */
    public static function edit(array $data, string $module)
    {
        $model = self::detail($data['id']);

        try {
            DB::beginTransaction();
            if ($result = $model->fill($data)->save()) {
                $model->roleModule()->delete();
                $model->saveModule($module);
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 保存模块
     * @param string $module
     */
    private function saveModule(string $module)
    {
        $module_id = explode(',', $module);
        $this->roleModule()->createMany(
            array_map(function ($value) {
                return ['module_id' => $value];
            }, $module_id)
        );
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
