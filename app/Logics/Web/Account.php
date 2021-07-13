<?php

namespace App\Logics\Web;

use App\Models\Account as AccountModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use Cache;
use Hash;
use Log;
use DB;

class Account extends AccountModel
{
    const USERNAME_EXIST  = '用户名已存在';
    const PASSWORD_ERROR  = '原始密码输入错误';

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $model->loginLog()->delete();
        });
    }

    /**
     * 获取用户
     * 自动根据请求中的 token 参数从缓存中获取账户ID
     * 并根据账户ID获取到该账户的模型
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function user()
    {
        return self::findOrFail(self::id());
    }

    /**
     * 根据请求中 token 参数从缓存中获取账户ID
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function id()
    {
        try {
            $cache = Cache::store('file')->get(get_token());
            return $cache['id'];
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return null;
        }
    }

    /**
     * 获取用户详细信息
     * @param int $id
     * @return mixed
     */
    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function getList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id asc';
        $username = $request->get('username');
        $disable  = $request->get('disable');
        $sort     = $request->get('sort');

        if (!empty($username)) {
            $filter[] = ['username', 'like', "%$username%"];
        }
        if (!empty($disable)) {
            $filter[] = ['disable', '=', $disable];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with(['role:id,role_name'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function add(array $data)
    {
        if (!self::where('username', $data['username'])->first()) {
            $model           = new static;
            $model->username = $data['username'];
            $model->password = Hash::make($data['password']);
            $model->realname = $data['realname'];
            $model->gender   = $data['gender'];
            $model->email    = $data['email'];
            $model->phone    = $data['phone'];
            $model->disable  = $data['disable'];
            $model->intro    = $data['intro'];
            $model->role_id  = $data['role_id'];
            return $model->save();
        }
        throw new AppException(self::USERNAME_EXIST);
    }

    /**
     * 修改账户信息
     * 未输入密码则不修改密码
     * @param array $data
     * @return bool
     * @throws AppException
     */
    public static function edit(array $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $model = self::where([
            ['id', '<>', $data['id']],
            ['username', '=', $data['username']]
        ])->first();

        if ($model) {
            throw new AppException(self::USERNAME_EXIST);
        }
        return self::where(['id' => $data['id']])->update($data) > 0;
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

    /**
     * 修改账户信息
     * @param array $data
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function changeInfo(array $data)
    {
        return self::user()->update($data);
    }

    /**
     * 修改账户密码
     * @param array $data
     * @return bool
     * @throws AppException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function changePassword(array $data)
    {
        $model = self::user();
        if (Hash::check($data['password'], $model->password) == true) {
            $model->password = Hash::make($data['new_password']);
            $model->save();
            return true;
        }
        throw new AppException(self::PASSWORD_ERROR);
    }
}
