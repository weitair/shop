<?php

namespace App\Logics\Web;

use App\Models\OrderLogistics as OrderLogisticsModel;

class OrderLogistics extends OrderLogisticsModel
{
    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }
}