<?php

namespace App\Logics\Web;

use App\Models\AccountLogin as AccountLoginModel;
use Illuminate\Http\Request;

class AccountLogin extends AccountLoginModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $sort    = $request->get('sort');

        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with('account')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }

    /**
     * 写日志
     * @param Account $account
     * @param int $status
     */
    public static function write(Account $account, int $status = self::STATUS_SUCCESS)
    {
        $request           = Request::capture();
        $model             = new static;
        $model->status     = $status;
        $model->user_agent = $request->header('user-agent');
        $model->client_ip  = get_client_ip();
        $model->login_time = time();
        $model->account_id = $account->id;
        $model->save();
    }

    /**
     * 指定时间段之内错误次数
     * @param Account $account
     * @param int $limitedTimeLength
     * @return mixed
     */
    public static function fails(Account $account, int $limitedTimeLength)
    {
        // 当前时间往前数15分钟
        $start = time() - $limitedTimeLength * 60;
        return self::where([
            ['login_time', '>', $start],
            ['account_id', '=', $account->id],
            ['status', '=', self::STATUS_FAIL]
        ])->count();
    }
}
