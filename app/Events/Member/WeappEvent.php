<?php

namespace App\Events\Member;

use App\Models\Member;
use Illuminate\Queue\SerializesModels;

class WeappEvent
{
    use SerializesModels;

    public $member;

    public $params;

    public function __construct(Member $member, array $params = [])
    {
        $this->member = $member;
        $this->params = $params;
    }
}
