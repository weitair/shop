<?php

namespace App\Events\Growth;

use App\Models\Member;
use Illuminate\Queue\SerializesModels;

class ChangeEvent
{
    use SerializesModels;
    // 调整成长值的用户
    public $member;
    // 调整多少成长值，小于 0 为减成长值
    public $growth;
    // 调整的原因
    public $intro;

    public function __construct(Member $member, int $growth, string $intro)
    {
        $this->member = $member;
        $this->growth = $growth;
        $this->intro  = $intro;
    }
}
