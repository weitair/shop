<?php

namespace App\Logics\Web;

use App\Models\MessageTemplate as MessageTemplateModel;
use App\Services\Wechat\Factory;
use Illuminate\Http\Request;
use Log;
use DB;

class MessageTemplate extends MessageTemplateModel
{
    public static function getList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'sort asc';
        $title   = $request->get('title');
        $sort    = $request->get('sort');

        if (!empty($title)) {
            $filter[] = ['title', 'like', "%$title%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->orderByRaw($order)
            ->get();
    }

    public static function getWeappList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id asc';
        $title   = $request->get('title');
        $sort    = $request->get('sort');

        if (!empty($title)) {
            $filter[] = ['title', 'like', "%$title%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return self::where($filter)
            ->where('weapp_tid', '>', 0)
            ->orderByRaw($order)
            ->get();
    }

    public static function getTemplate(string $id)
    {
        try {
            DB::beginTransaction();
            $id = explode(',', $id);
            $result = self::whereIn('id', $id)->get();
            $wechat = Factory::getInstance('weapp');

            foreach ($result as $item) {
                if (!empty($item->weapp_template_id)) {
                    $wechat->app->subscribe_message->deleteTemplate($item->weapp_template_id);
                }
                $tid       = $item->weapp_tid;
                $kidList   = json_decode($item->weapp_value);
                $sceneDesc = $item->title;
                $result    = $wechat->app->subscribe_message->addTemplate($tid, $kidList, $sceneDesc);

                if ($result['errcode'] == 0) {
                    $item->weapp_template_id = $result['priTmplId'];
                    $item->save();
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function edit(array $data)
    {
        return self::detail($data['id'])
            ->fill($data)
            ->save();
    }
}
