<?php

namespace App\Models;

use App\Exceptions\AppException;
use Cache;
use File;
use Log;

class Setting extends Model
{
    protected $table    = 'setting';

    protected $hidden   = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['category', 'key', 'values'];

    /**
     * 系统安全设置
     */
    const LOCK = 1; // 锁定账户功能(0：关闭、1：开启)

    /**
     * 消息设置
     */
    const SMS = 1; // 发送短信功能(0：关闭、1：开启)

    /**
     * 物流
     */
    // 配送方式
    const LOGISTICS_METHOD_EXPRESS = 0; // 快递发货
    const LOGISTICS_METHOD_LOCAL   = 1; // 同城配送
    const LOGISTICS_METHOD_FETCH   = 2; // 上门自提

    // 运费计算方式(0：叠加、1：最低、2：最高)
    const LOGISTICS_PLAN_TOTAL = 0;
    const LOGISTICS_PLAN_MIN   = 1;
    const LOGISTICS_PLAN_MAX   = 2;

    // 本地配送模板计价方式(0：按距离、1：按重量)
    const LOCAL_METHOD_DISTANCE = 0;
    const LOCAL_METHOD_WEIGHT   = 1;

    /**
     * 订单
     */
    // 减库存策略(0：下单减库存、1：支付减库存)
    const ORDER_STOCK_PLAN_ORDER   = 0;
    const ORDER_STOCK_PLAN_PAYMENT = 1;

    // 是否支持开具发票(0：否、1：是)
    const ORDER_INVOICE = 1;

    protected $params;

    public function __construct(array $params = [])
    {
        parent::__construct();

        $this->params = $params;
    }

    public static function getInstance(string $params)
    {
        if (($index = strpos($params, '.')) === false) {
            throw new AppException('参数错误');
        }

        return new static([
            'category' => substr($params, 0, $index),
            'key'      => substr($params, $index + 1)
        ]);
    }

    public function fetch()
    {
        try {
            $key = 'setting_' . $this->params['category'] . '_' . $this->params['key'];
            $model = Cache::store('file')->rememberForever($key, function () {
                return self::where([
                    'category' => $this->params['category'],
                    'key'      => $this->params['key']
                ])->first();
            });

            if (!empty($model)) {
                $model->values = json_decode($model->values);
                if (!empty($model->values)) {
                    $method = 'fetch' . ucfirst($this->params['category']) . ucfirst($this->params['key']);
                    if (method_exists($model, $method)) {
                        $model->{$method}();
                    }
                    return json_decode(json_encode($model->values), true);
                }
            }
            return null;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return null;
        }
    }

    /**
     * 保存设置内容
     * @param $data
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function submit($data)
    {
        $this->where([
            'category' => $this->params['category'],
            'key' => $this->params['key'],
        ])->delete();

        $this->category = $this->params['category'];
        $this->key      = $this->params['key'];
        $this->values   = $data;

        $method = 'submit' . ucfirst($this->params['category']) . ucfirst($this->params['key']);
        if (method_exists($this, $method)) {
            $this->{$method}();
        }
        Cache::store('file')->forget('setting_' . $this->params['category'] . '_' . $this->params['key']);
        Cache::store('file')->forget('setting_' . $this->params['category']);
        return $this->save();
    }

    /**
     * 获取应用信息
     */
    public function fetchAppBase()
    {
        if (strpos($this->values->app_logo, 'http') === false) {
            $this->values->app_logo = config('app.url') . '/' . $this->values->app_logo;
        }
    }

    /**
     * 获取系统基本信息
     */
    public function fetchSystemBase()
    {
        if (strpos($this->values->logo, 'http') === false) {
            $this->values->logo = config('app.url') . '/' . $this->values->logo;
        }
    }

    /**
     * 获取 tabbar
     */
    public function fetchDesignTabbar()
    {
        foreach ($this->values->item as $item) {
            if (strpos($item->image, 'http') === false) {
                $item->image = config('app.url') . '/' . $item->image;
            }
            if (strpos($item->image_active, 'http') === false) {
                $item->image_active = config('app.url') . '/' . $item->image_active;
            }
        }
    }

    /**
     * 获取会员中心
     */
    public function fetchDesignMine()
    {
        foreach ($this->values as $item) {
            if ($item->type == 'grid') {
                foreach ($item->data->images as $sitem) {
                    if (strpos($sitem->image, 'http') === false) {
                        $sitem->image = config('app.url') . '/' . $sitem->image;
                    }
                }
            }
        }
    }

    /**
     * 保存微信支付设置，上传证书
     */
    public function submitPaymentWechat()
    {
        if ($values = json_decode($this->values)) {
            if (!empty($values->apiclient_key) && !empty($values->apiclient_cert)) {
                $apiclient_key  = $values->apiclient_key;
                $apiclient_cert = $values->apiclient_cert;
                $filepath       = base_path('cert/wechat');

                if (!File::isDirectory($filepath)) File::makeDirectory($filepath, 0755, true);
                File::put($filepath . '/apiclient_key.pem', $apiclient_key);
                File::put($filepath . '/apiclient_cert.pem', $apiclient_cert);
            }
            unset($values->apiclient_key);
            unset($values->apiclient_cert);
            $this->values = json_encode($values);
        }
    }
}
