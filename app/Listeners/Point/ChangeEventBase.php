<?php

namespace App\Listeners\Point;

use App\Events\Point\ChangeEvent;
use App\Models\Point;

class ChangeEventBase
{
    public function handle(ChangeEvent $event)
    {
        $member = $event->member;
        $point  = $event->point;
        $intro  = $event->intro;

        if ($point != 0) {
            $point = $member->point + $point < 0 ? -$member->point : $point;
            $member->point()->save(
                new Point([
                    'point'       => $point,
                    'type'        => $point > 0 ? Point::TYPE_INCOME : Point::TYPE_EXPENSES,
                    'intro'       => $intro,
                    'change_time' => time()
                ])
            );
            $member->point += $point;
            $member->save();
        }
    }
}
