<?php

namespace App\Logics\Web;

use App\Models\SpecValue as SpecValueModel;

class SpecValue extends SpecValueModel
{
    public static function detail(int $id)
    {
        return self::with(['spec'])->findOrFail($id);
    }
}
