<?php

namespace App\Logics\Api;

use Addon\Coupon\Models\Coupon;
use App\Services\Wechat\Factory as WechatFactory;
use App\Services\Poster\Factory as PosterFactory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Goods as GoodsModel;
use Nwidart\Modules\Facades\Module;
use App\Exceptions\AppException;
use App\Events\Goods\ViewEvent;
use App\Models\OrderComment;
use Illuminate\Http\Request;
use Event;

class Goods extends GoodsModel
{
    const QUOTA_ON = '超过限购数量';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    /**
     * 覆写评价表，增加限制条件
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class)
            ->where(function (Builder $query) {
                // 自己发的任何条件下都可以看见
                return $query->where('status', OrderComment::STATUS_PASS)
                    ->orWhere('member_id', Member::id());
            })
            ->orderBy('top_status', 'desc')
            ->limit(1);
    }

    public static function getList()
    {
        $request    = Request::capture();
        $keyword    = $request->get('keyword');
        $category   = $request->get('category');
        $price_min  = $request->get('price_min');
        $price_max  = $request->get('price_max');
        $order_type = $request->get('order_type');
        $order_sort = $request->get('order_sort');

        $filter = [];
        if (!empty($keyword)) {
            $filter[] = ['goods_name', 'like', "%$keyword%"];
        }
        if (!empty($price_min)) {
            $filter[] = ['sales_price', '>=', $price_min * 100];
        }
        if (!empty($price_max)) {
            $filter[] = ['sales_price', '<=', $price_max * 100];
        }

        switch ($order_type) {
            case 1: // 销量
                $order = '(sales_init + sales) desc';
                break;
            case 2: // 价格
                $order = $order_sort == 'asc' ? 'sales_price asc' : 'sales_price desc';
                break;
            default: // 综合
                $order = 'sort asc';
        }

        return self::where($filter)
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('category', function (Builder $query) use ($category) {
                    $query->where('category_id', $category);
                });
            })
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        $detail = self::with([
            'images',
            'sku',
            'spec',
            'specValue',
            'support',
            'comment.member',
        ])
            ->withCount('comment')
            ->findOrFail($id);

        Event::dispatch(new ViewEvent($detail));

        $detail->coupon = Coupon::where('status', Coupon::STATUS_START)
            ->where('coupon_visible', Coupon::COUPON_VISIBLE_ON)
            ->where('expire_type', Coupon::EXPIRE_TYPE_DYNAMIC)
            ->orWhere(function ($query) {
                $query->where('expire_type', Coupon::EXPIRE_TYPE_FIXED)
                    ->where('end_time', '>', time());
            })
            ->where(function ($query) use ($detail) {
                $query->where('goods_limit', Coupon::GOODS_LIMIT_ALL)
                    ->orWhere(function ($query) use ($detail) {
                        $query->where('goods_limit', Coupon::GOODS_LIMIT_AVAILABLE)
                            ->whereHas('goods', function (Builder $query) use ($detail) {
                                $query->where('goods_id', $detail->id);
                            });
                    })
                    ->orWhere(function ($query) use ($detail) {
                        $query->where('goods_limit', Coupon::GOODS_LIMIT_UNAVAILABLE)
                            ->whereHas('goods', function (Builder $query) use ($detail) {
                                $query->where('goods_id', '<>', $detail->id);
                            });
                    });
            })
            ->orderBy('amount', 'desc')
            ->orderBy('discount', 'desc')
            ->get();

        return $detail;
    }

    /**
     * 商品评论列表
     * @return mixed
     */
    public static function comments()
    {
        $request = Request::capture();
        $data    = $request->all();
        $filter  = [];

        if (isset($data['type'])) {
            switch ($data['type']) {
                case 'praise':
                    $filter = ['satisfaction' => OrderComment::SATISFACTION_PRAISE];
                    break;
                case 'middle':
                    $filter = ['satisfaction' => OrderComment::SATISFACTION_MIDDLE];
                    break;
                case 'fail':
                    $filter = ['satisfaction' => OrderComment::SATISFACTION_FAIL];
                    break;
                case 'image':
                    $filter = ['image_status' => 1];
                    break;
            }
        }

        return self::findOrFail($data['id'])
            ->comment()
            ->with(['images', 'member'])
            ->where($filter)
            ->orderBy('top_status', 'desc')
            ->orderBy('satisfaction', 'desc')
            ->orderBy('comment_time', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    /**
     * 查询是否达到限购
     * @param int $id
     * @param int $quantity
     * @return bool
     * @throws AppException
     */
    public static function checkQuota(int $id, int $quantity)
    {
        $detail = self::findOrFail($id);

        if ($detail->quota_quantity > 0 && $detail->quota_quantity < $quantity) {
            throw new AppException(self::QUOTA_ON);
        }
        return true;
    }

    /**
     * 生成海报
     * @return mixed
     */
    public static function poster()
    {
        $params  = Request::capture()->all();
        $id      = $params['id'];
        $type    = $params['type'];
        $goods   = self::with('images')->findOrFail($id);
        $setting = Setting::getInstance('goods.share')->fetch();
        $member  = null;
        $scene   = 'r=goods&id=' . $id;

        if (Member::id()) {
            $member = Member::user();

            // 分销商
            if ($member->fenxiao == Member::FENXIAO_ON) {
                if (Module::has('Fenxiao')) {
                    $fenxiao_id = \Addon\Fenxiao\Logics\Api\Fenxiao::id();
                    $scene      = 'r=goods&id=' . $id . '&fx=' . $fenxiao_id;
                }
            }
        }

        switch ($type) {
            case 0:
                $qrcode = QrCode::format('png')
                    ->size(200)
                    ->generate(config('app.url') . '/h5/#/?scene=' . urlencode($scene));
                $qrcode = 'data:image/png;base64,' . base64_encode($qrcode);
                break;
            case 1:
                $qrcode = WechatFactory::getInstance('weapp')->getUnlimit($scene);
                break;
        }

        $poster = PosterFactory::getInstance([
            'width'      => 750,
            'height'     => 1200,
            'background' => $setting['background'],
        ]);
        return $poster->make($qrcode, $goods, $setting, $member);
    }
}
