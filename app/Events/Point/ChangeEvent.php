<?php

namespace App\Events\Point;

use App\Models\Member;
use Illuminate\Queue\SerializesModels;

class ChangeEvent
{
    use SerializesModels;
    // 调整积分的用户
    public $member;
    // 调整多少积分，小于 0 为减积分
    public $point;
    // 调整的原因
    public $intro;

    public function __construct(Member $member, int $point, string $intro)
    {
        $this->member = $member;
        $this->point  = $point;
        $this->intro  = $intro;
    }
}
