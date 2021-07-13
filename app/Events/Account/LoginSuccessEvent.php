<?php

namespace App\Events\Account;

use App\Logics\Web\Account;
use Illuminate\Queue\SerializesModels;

class LoginSuccessEvent
{
    use SerializesModels;

    public $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }
}
