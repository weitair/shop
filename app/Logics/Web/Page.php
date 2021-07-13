<?php

namespace App\Logics\Web;

use App\Models\Page as PageModel;
use Illuminate\Http\Request;
use Cache;

class Page extends PageModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'sort asc';
        $title   = $request->get('title');
        $intro   = $request->get('intro');
        $sort    = $request->get('sort');

        if (!empty($title)) {
            $filter[] = ['title', 'like', "%$title%"];
        }
        if (!empty($intro)) {
            $filter[] = ['intro', 'like', "%$intro%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function add(array $data)
    {
        $model          = new static;
        $model->title   = $data['title'];
        $model->header  = $data['header'];
        $model->content = $data['content'];
        $model->sort    = $data['sort'];
        return $model->save();
    }

    public static function edit(array $data)
    {
        $detail          = self::detail($data['id']);
        $detail->title   = $data['title'];
        $detail->header  = $data['header'];
        $detail->content = $data['content'];
        Cache::store('file')->forget('page_' . $detail->id);
        return $detail->save();
    }

    public static function setHome(int $id)
    {
        $home       = self::where('home', self::HOME_ON)->first();
        $home->home = self::HOME_OFF;
        $home->save();

        $model         = self::detail($id);
        $model->status = self::STATUS_ON;
        $model->home   = self::HOME_ON;
        Cache::store('file')->forget('page_home');
        return $model->save();
    }

    public static function getHome()
    {
        return self::where('home', self::HOME_ON)->first();
    }

    public static function saveHome(string $header, string $params)
    {
        $model          = self::getHome();
        $model->header  = $header;
        $model->content = $params;
        Cache::store('file')->forget('page_home');
        return $model->save();
    }

    public static function status(int $id)
    {
        $model         = self::detail($id);
        $model->status = $model->status == self::STATUS_OFF ? self::STATUS_ON : self::STATUS_OFF;
        Cache::store('file')->forget('page_' . $model->id);
        return $model->save();
    }

    public static function remove(string $id)
    {
        Cache::store('file')->forget('page_' . $id);
        return self::destroy($id) >= 0;
    }
}
