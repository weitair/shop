<?php

namespace App\Helper;

class Tree
{
    public static function make(&$data, $pid = 0, $selected = -1)
    {
        $tree = [];
        foreach ($data as $item) {
            if ($item['parent_id'] == $pid) {
                $item['children'] = self::make($data, $item['id'], $selected);
                if ($item['children'] == null) {
                    unset($item['children']);
                }
                $item['disabled'] = $selected == $item['id'];
                $tree[] = $item;
            }
        }
        return $tree;
    }
}
