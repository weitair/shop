<?php

namespace App\Logics\Web;

use App\Exceptions\AppException;
use App\Models\WechatFans as WechatFansModel;
use App\Services\Wechat\Factory;
use Illuminate\Http\Request;
use Log;
use DB;

class WechatFans extends WechatFansModel
{
    public static function getList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'subscribe_time desc';
        $nickname = $request->get('nickname');
        $sort     = $request->get('sort');

        if (!empty($nickname)) {
            $filter[] = ['nickname', 'like', "%$nickname%"];
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

    public static function getFans()
    {
        try {
            DB::beginTransaction();
            $wechat = Factory::getInstance('base');
            $openid = $wechat->app->user->list();
            $total  = $openid['total'];
            $next   = $openid['next_openid'];
            $data   = $openid['data']['openid'];
            $result = $wechat->app->user->select($data);

            if (isset($result['errcode'])) {
                throw new AppException();
            }

            $model = new static;
            foreach ($result['user_info_list'] as $item) {
                if ($detail = self::where('openid', $item['openid'])->first()) {
                    $item['nickname'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $item['nickname']);
                    $detail->fill($item)->save();
                } else {
                    $model->create($item);
                }
            }
            DB::commit();
            return true;
        } catch (AppException $e) {
            throw new AppException('同步粉丝信息出现错误');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }
}
