<?php

namespace App\Events\Member;

use App\Models\Member;
use Illuminate\Queue\SerializesModels;

class LoginEvent
{
    use SerializesModels;

    public $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }
}
