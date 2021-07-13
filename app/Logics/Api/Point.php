<?php

namespace App\Logics\Api;

use App\Models\Point as PointsModel;
use Illuminate\Http\Request;
use Log;

class Point extends PointsModel
{
    public static function getList()
    {
        $request = Request::capture();
        $status = $request->get('status');

        $filter[] = $status == 0 ? ['point', '>', 0] : ['point', '<', 0];
        $order = 'record_time desc';

        return Member::user()->point()
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 记录积分
     * @param int $point
     * @param string $intro
     * @param int $member_id
     * @return bool
     */
    public static function record(int $point, string $intro, int $member_id = 0)
    {
        try {
            if ($point != 0) {
                // 微信通知后没携带Token
                $member = $member_id > 0 ? Member::findOrFail($member_id) : Member::user();
                $member->point()
                    ->save(
                        new static([
                            'point'       => $point,
                            'intro'       => $intro,
                            'record_time' => time()
                        ])
                    );
                $member->point += $point;
                $member->save();
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}