<?php

namespace App\Logics\Web;

use App\Helper\Tree;
use App\Models\Region as RegionModel;

class Region extends RegionModel
{
    public static function list()
    {
        $list = self::select(['id', 'parent_id', 'level', 'name'])
            ->where('level', '<', 2)
            ->orderBy('id', 'asc')
            ->orderBy('sort', 'asc')
            ->get();
        $list = $list->toArray();
        return Tree::make($list, 0);
    }
}
