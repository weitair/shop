<?php

namespace App\Listeners\Goods;

use App\Events\Goods\ViewEvent;
use App\Logics\Api\GoodsHistory;
use App\Logics\Api\Member;
use App\Helper\Date;

class ViewEventHistory
{
    public function handle(ViewEvent $event)
    {
        // 已登录的用户才记录历史
        if ($member_id = Member::id()) {
            $id        = $event->goods->id;
            $today     = Date::today();
            $model     = GoodsHistory::whereBetween('view_time', [$today['start'], $today['end']])
                ->where(['goods_id' => $id, 'member_id' => $member_id])
                ->first();

            // 当日未浏览过该商品才加入历史
            if (empty($model)) {
                $model             = new GoodsHistory;
                $model->goods_id   = $id;
                $model->member_id  = $member_id;
                $model->view_time  = time();
                $model->save();
            } else {
                $model->view_total += 1;
                $model->save();
            }
        }
    }
}
