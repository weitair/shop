<?php

namespace App\Logics\Api;

use App\Models\MemberInvoice as MemberInvoiceModel;

class MemberInvoice extends MemberInvoiceModel
{
    public static function detail()
    {
        return Member::user()->invoice;
    }

    public static function submit(array $data)
    {
        $member = Member::user();
        return $member->invoice()->updateOrCreate([], $data);
    }
}
