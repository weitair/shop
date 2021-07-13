<?php

namespace App\Logics\Web;

use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Storage\Factory;
use Illuminate\Http\Request;
use App\Helper\Tree;
use Storage;
use File;
use Log;
use DB;

class Select
{
    public static function memberList()
    {
        $request  = Request::capture();
        $filter   = [];
        $order    = 'id desc';
        $id       = $request->get('id');
        $nickname = $request->get('nickname');
        $phone    = $request->get('phone');
        $sort     = $request->get('sort');

        if (!empty($id)) {
            $filter[] = ['id', 'like', "%$id%"];
        }
        if (!empty($nickname)) {
            $filter[] = ['nickname', 'like', "%$nickname%"];
        }
        if (!empty($phone)) {
            $filter[] = ['phone', 'like', "%$phone%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return Member::select('id', 'nickname', 'avatar', 'channel', 'register_time')
            ->with(['level'])
            ->with(['invite' => function ($query) {
                $query->select('id', 'nickname', 'avatar');
            }])
            ->withCount(['order' => function (Builder $query) {
                $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED);
            }])
            ->withCount(['order as order_payment' => function (Builder $query) {
                $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED)
                    ->select(DB::raw("round(sum(payment_price/100), 2)"));
            }])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', Member::PAGE)
            );
    }

    public static function couponList()
    {
        $request     = Request::capture();
        $filter      = [];
        $order       = 'id desc';
        $coupon_name = $request->get('name');
        $coupon_type = $request->get('type');
        $record      = $request->get('record'); // 是否可被领取
        $sort        = $request->get('sort');

        if (!empty($coupon_name)) {
            $filter[] = ['coupon_name', 'like', "%$coupon_name%"];
        }
        if (!empty($coupon_type)) {
            $filter[] = ['coupon_type', '=', $coupon_type];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return \Addon\Coupon\Logics\Web\Coupon::where($filter)
            ->where('status', \Addon\Coupon\Logics\Web\Coupon::STATUS_START)
            ->where('coupon_visible', $record)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', \Addon\Coupon\Logics\Web\Coupon::PAGE)
            );
    }

    public static function pageList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $title   = $request->get('title');

        if (!empty($title)) {
            $filter[] = ['title', 'like', "%$title%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return Page::where($filter)
            ->where('status', Page::STATUS_ON)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', Page::PAGE)
            );
    }

    public static function articleList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $title   = $request->get('title');

        if (!empty($title)) {
            $filter[] = ['title', 'like', "%$title%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return \Addon\Article\Logics\Web\Article::with('category')
            ->where($filter)
            ->where('status', \Addon\Article\Logics\Web\Article::STATUS_ON)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', \Addon\Article\Logics\Web\Article::PAGE)
            );
    }

    public static function goodsList()
    {
        $request    = Request::capture();
        $filter     = [];
        $order      = 'id asc';
        $goods_name = $request->get('name');
        $category   = $request->get('category');
        $group      = $request->get('group');
        $sort       = $request->get('sort');

        if (!empty($goods_name)) {
            $filter[] = ['goods_name', 'like', "%$goods_name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return Goods::where($filter)
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('category', function (Builder $query) use ($category) {
                    $query->where('category_id', $category);
                });
            })
            ->when($group, function ($query) use ($group) {
                return $query->whereHas('group', function (Builder $query) use ($group) {
                    $query->where('group_id', $group);
                });
            })
            ->where('status', Goods::STATUS_ON)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', Goods::PAGE)
            );
    }

    public static function categoryList()
    {
        $data = GoodsCategory::withCount('goods')->orderBy('sort', 'asc')->get();
        foreach ($data as $item) {
            $item->disabled = $item->status == GoodsCategory::STATUS_OFF;
        }
        return Tree::make($data, 0);
    }

    public static function assetsGrouopList()
    {
        return AssetsGroup::orderBy('sort', 'asc')->get();
    }

    public static function assetsList()
    {
        $request = Request::capture();
        $filter  = [];
        $order   = 'id desc';
        $group   = $request->get('group');
        $name    = $request->get('name');

        if (!empty($group)) {
            $filter[] = ['group_id', '=', $group];
        }
        if (!empty($name)) {
            $filter[] = ['name', 'like', "%$name%"];
        }
        if (!empty($sort)) {
            $order = str_replace_first(':', ' ', $sort);
        }

        return Assets::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', 10)
            );
    }

    public static function assetsMove(int $group_id, string $id)
    {
        return Assets::whereIn('id', explode(',', $id))->update(['group_id' => $group_id]) >= 0;
    }

    public static function assetsRemove(string $id)
    {
        return Assets::destroy(explode(',', $id)) > 0;
    }

    public static function assetsGroupAdd(array $data)
    {
        $model = new AssetsGroup;
        $model->sort = $model->getMaxSort();
        $model->group_name = $data['group_name'];
        return $model->save();
    }

    public static function assetsUpload(int $group_id, array $file)
    {
        $model              = new Assets;
        $model->account_id  = Account::id();
        $model->group_id    = $group_id;
        $model->name        = $file['name'];
        $model->path        = $file['file'];
        $model->type        = $file['type'];
        $model->size        = $file['size'];
        $model->upload_time = time();
        return $model->save();
    }

    public static function assetsRemote(array $data)
    {
        $group_id   = empty($data['group_id']) ? 0 : $data['group_id'];
        $image_link = $data['image_link'];
        $accept     = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
        $pathinfo   = pathinfo($image_link);

        if (!in_array($pathinfo['extension'], $accept)) {
            throw new AppException('图片格式错误');
        }

        $filename = date('YmdHis')
            . substr(md5($image_link), 0, 5)
            . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT)
            . '.' . $pathinfo['extension'];

        try {
            $stream   = file_get_contents($image_link);
            $filepath = config('filesystems.disks.image.path') . $filename;

            if (Storage::disk('upload')->put($filepath, $stream)) {
                $path = config('app.url') . $filepath;
            }

            $file['file'] = $path;
            $file['name'] = empty($pathinfo['basename']) ? '' : $pathinfo['basename'];
            $file['type'] = 'image/' . $pathinfo['extension'];
            $file['size'] = 0;
            return self::assetsUpload($group_id, $file);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
