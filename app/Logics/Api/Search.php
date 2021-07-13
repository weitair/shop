<?php

namespace App\Logics\Api;

use App\Models\Search as SearchModel;

class Search extends SearchModel
{
    public static function search(string $keyword)
    {
        if ($id = Member::id()) {
            $model = self::where([
                'keyword'   => $keyword,
                'member_id' => $id
            ])->first();

            if (empty($model)) {
                $model = new static;
                $model->keyword     = $keyword;
                $model->search_time = time();
                $model->member_id   = $id;
                $model->save();
            }
        }
    }

    public static function history()
    {
        if ($id = Member::id()) {
            return self::where('member_id', $id)
                ->orderBy('id', 'desc')
                ->limit(20)
                ->get();
        }
        return [];
    }



    public static function clear()
    {
        if ($id = Member::id()) {
            return self::where('member_id', $id)->delete();
        }
        return true;
    }
}
