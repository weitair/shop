<?php

namespace App\Listeners\Growth;

use App\Events\Growth\ChangeEvent;
use App\Models\Growth;

class ChangeEventBase
{
    public function handle(ChangeEvent $event)
    {
        $member = $event->member;
        $growth = $event->growth;
        $intro  = $event->intro;

        if ($growth != 0) {
            $growth = $member->growth + $growth < 0 ? -$member->growth : $growth;
            $member->growth()->save(
                new Growth([
                    'growth'      => $growth,
                    'type'        => $growth > 0 ? Growth::TYPE_INCOME : Growth::TYPE_EXPENSES,
                    'intro'       => $intro,
                    'change_time' => time()
                ])
            );
            $member->growth += $growth;
            $member->save();
        }
    }
}
