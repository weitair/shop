<?php

namespace App\Logics\Api;

use App\Models\Page as PageModel;
use Illuminate\Database\Eloquent\Builder;
use Cache;
use Log;

class Page extends PageModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function home()
    {
        $key = 'page_home';
        $page = Cache::store('file')->rememberForever($key, function () {
            return self::where('home', self::HOME_ON)->first();
        });
        $page->increment('view');
        $page = json_decode(json_encode($page), true);
        $page['content'] = self::getResult($page['content']);
        return $page;
    }

    public static function detail(int $id)
    {
        $key = 'page_' . $id;
        $page = Cache::store('file')->rememberForever($key, function () use ($id) {
            return self::where([
                'id' => $id
            ])->first();
        });

        if ($page) {
            $page->increment('view');
            $page = json_decode($page, true);
            $page['content'] = self::getResult($page['content']);
        }
        return $page;
    }

    /**
     * 返回解析之后的数据
     * @param array $content
     * @return array
     */
    public static function getResult(array $content)
    {
        if (!empty($content)) {
            foreach ($content as $key => $item) {
                if ($item['type'] == 'coupon') {
                    $content[$key]['data']['result'] = Page::getCouponList($item['data']);
                }
                if ($item['type'] == 'goods') {
                    $content[$key]['data']['result'] = Page::getGoodsList($item['data']);
                }
                if ($item['type'] == 'article') {
                    $content[$key]['data']['result'] = Page::getArticleList($item['data']);
                }
            }
        }
        return $content;
    }

    public static function getGoodsList(array $params)
    {
        try {
//            $key = 'page_goods_' . md5(json_encode($params));
//            return Cache::rememberForever($key, function () use ($params) {

            $order = 'sort asc';
            if ($params['sort'] == 'price') {
                $order = 'sales_price asc';
            }
            if ($params['sort'] == 'sale') {
                $order = '(sales_init + sales) desc';
            }

            if ($params['option'] == 'goods') {
                if ($params['data'] == 'auto') {
                    $result = Goods::when($params['group'], function ($query) use ($params) {
                        return $query->whereHas('group', function (Builder $query) use ($params) {
                            $query->where('group_id', $params['group']);
                        });
                    })
                        ->orderByRaw($order)
                        ->limit($params['limit'])
                        ->get();
                } else {
                    $id = array_column($params['goods'], 'id');
                    $result = Goods::whereIn('id', $id)
                        ->orderByRaw($order)
                        ->get();
                }
            } else {
                $result = GoodsGroup::whereIn('id', $params['group_multi'])->orderBy('sort', 'asc')->get();
                foreach ($result as $item) {
                    $item->goods = $item->goods()
                        ->where('status', GoodsGroup::STATUS_ON)
                        ->orderByRaw($order)
                        ->limit($params['limit'])
                        ->get();
                }
            }
            return $result;
//            });
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return [];
        }
    }

    public static function getCouponList(array $params)
    {
        try {
            if ($params['option'] == 'auto') {
                $list = \Addon\Coupon\Logics\Api\Coupon::where(function ($query) {
                    $query->where('expire_type', \Addon\Coupon\Logics\Api\Coupon::EXPIRE_TYPE_DYNAMIC)
                        ->orWhere('end_time', '>', time());
                })
                    ->when($params['hide'], function ($query) {
                        return $query->whereRaw('total > received');
                    })
                    ->when($params['limit'] == 'all', function ($query) use ($params) {
                        return $query->offset(0)->limit(10);
                    })
                    ->when($params['limit'] == 'number', function ($query) use ($params) {
                        return $query->offset(0)->limit($params['limit_number']);
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $id = array_column($params['coupon'], 'id');
                $list = \Addon\Coupon\Logics\Api\Coupon::whereIn('id', $id)
                    ->where(function ($query) {
                        $query->where('expire_type', \Addon\Coupon\Logics\Api\Coupon::EXPIRE_TYPE_DYNAMIC)
                            ->orWhere('end_time', '>', time());
                    })
                    ->when($params['hide'], function ($query) {
                        return $query->whereRaw('total > received');
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            }
            return $list;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return [];
        }
    }

    public static function getArticleList(array $params)
    {
        try {
            if ($params['data'] == 'auto') {
                $result = \Addon\Article\Models\Article::orderBy('id', 'desc')
                    ->limit($params['limit'])
                    ->get();
            } else {
                $id = array_column($params['article'], 'id');
                $result = \Addon\Article\Models\Article::whereIn('id', $id)
                    ->orderBy('id', 'desc')
                    ->get();
            }
            return $result;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return [];
        }
    }
}
