<?php

namespace Addon\Newcomer\Events;

use Illuminate\Queue\SerializesModels;
use App\Logics\Api\Member;

class RegisterEvent
{
    use SerializesModels;

    public $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
