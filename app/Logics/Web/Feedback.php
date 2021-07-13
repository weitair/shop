<?php

namespace App\Logics\Web;

use App\Models\Feedback as FeedbackModel;
use Illuminate\Http\Request;

class Feedback extends FeedbackModel
{
    public static function getList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id desc';
        $category = $request->get('category');
        $contact  = $request->get('contact');
        $content  = $request->get('content');
        $sort     = $request->get('sort');

        if (!empty($category)) {
            $filter[] = ['category_id', '=', $category];
        }
        if (!empty($contact)) {
            $filter[] = ['contact', 'like', "%$contact%"];
        }
        if (!empty($content)) {
            $filter[] = ['content', 'like', "%$content%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::has('category')
            ->with(['category'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
