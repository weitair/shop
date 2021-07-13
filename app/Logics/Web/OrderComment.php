<?php

namespace App\Logics\Web;

use App\Models\OrderComment as OrderCommentModel;
use Illuminate\Http\Request;

class OrderComment extends OrderCommentModel
{
    public static function getList()
    {
        $request      = Request::capture();
        $filter       = [];
        $order        = 'id desc';
        $status       = $request->get('status', 0);
        $satisfaction = $request->get('satisfaction');
        $reply        = $request->get('reply');
        $sort         = $request->get('sort');

        $filter[] = ['status', '=', $status];

        if (is_numeric($satisfaction)) {
            $filter[] = ['satisfaction', '=', $satisfaction];
        }
        if (is_numeric($reply)) {
            $filter[] = ['reply_status', '=', $reply];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::with(['order', 'member', 'images'])
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

    public static function audit(array $data)
    {
        $id = explode(',', $data['id']);
        return self::whereIn('id', $id)->update(['status' => $data['status']]) >= 0;
    }

    public static function reply(array $data)
    {
        $model = self::detail($data['id']);
        $model->top_status = $data['top_status'];
        $model->reply = $data['reply'];
        $model->reply_time = time();
        $model->reply_status = self::REPLY_STATUS_FINISH;
        return $model->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
