<?php

namespace App\Logics\Api;

use App\Models\Cart as CartModel;
use App\Exceptions\AppException;

class Cart extends CartModel
{
    public static function getList()
    {
        return self::has('goods')
            ->has('sku')
            ->with(['goods'])
            ->where('member_id', Member::id())
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * 失效商品
     * @return array
     */
    public static function getFailureList()
    {
        $list = [];
        $result = self::with(['goods', 'sku'])
            ->where('member_id', Member::id())
            ->orderBy('id', 'desc')
            ->get();

        foreach ($result as $item) {
            if (empty($item->goods) || empty($item->sku)) {
                $list[] = $item;
            }
        }
        return $list;
    }

    /**
     * 获取用户购物车内商品总数
     * @return mixed
     */
    public static function getCount()
    {
        return self::has('goods')
            ->where('member_id', Member::id())
            ->sum('quantity');
    }

    /**
     * 添加到购物车
     * @param array $data
     * @return mixed
     * @throws AppException
     */
    public static function add(array $data)
    {
        $member = Member::user();
        $model  = $member->cart()
            ->where(['goods_sku_id' => $data['goods_sku_id']])
            ->first();

        if (empty($model)) {
            $model = new static;
        }
        $model->goods_id = $data['goods_id'];
        $model->goods_sku_id = $data['goods_sku_id'];
        $model->goods_name = $data['goods_name'];
        $model->sku_name = $data['sku_name'];
        $model->image = $data['image'];
        $model->sales_price = $data['sales_price'];
        $model->quantity += $data['quantity'];
        $model->add_time = time();

        // 查询是否达到限购
        Goods::checkQuota($model->goods_id, $model->quantity);
        // 查询库存是否充足
        GoodsSku::checkStock($model->goods_sku_id, $model->quantity);
        return $member->cart()->save($model);
    }

    /**
     * 更新购物车
     * @param array $data
     * @return mixed
     * @throws AppException
     */
    public static function change(array $data)
    {
        $model = Member::user()->cart()
            ->where(['id' => $data['id']])
            ->first();

        // 查询是否达到限购
        Goods::checkQuota($model->goods_id, $data['quantity']);
        // 查询库存是否充足
        GoodsSku::checkStock($model->goods_sku_id, $data['quantity']);
        $model->quantity = $data['quantity'];
        return $model->save();
    }

    /**
     * 清空失效商品
     * @return bool
     */
    public static function clear()
    {
        $result = self::getFailureList();
        $id = [];

        foreach ($result as $item) {
            $id[] = $item['id'];
        }
        if (count($id) > 0) {
            return self::destroy($id) > 0;
        }
        return true;
    }

    public static function remove(array $id)
    {
        return self::destroy($id) > 0;
    }
}
