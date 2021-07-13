<?php

namespace App\Logics\Api;

use App\Models\Template as ExpressTemplateModel;

class Template extends ExpressTemplateModel
{
    public static function getFee(int $id, int $quantity, float $weight, string $city)
    {
        $detail = self::detail($id);
        $rule   = null;
        foreach ($detail->item as $item) {
            $citys = [];
            $list = json_decode($item->region, true);
            foreach ($list as $subItem) {
                $citys[] = $subItem[1];
            }
            // 是否在配送范围
            in_array($city, $citys) && $rule = $item;
        }

        if (!empty($rule)) {
            // 根据计费方式获取总件或是总重
            $total = $detail->method == self::METHOD_QUANTITY ? $quantity : $weight;

            // 小于首件阈值，直接返回首件费用
            if ($total <= $rule->first) {
                return $rule->first_fee;
            }

            // 续件大于 0，有计算规则继续计算
            $additional_fee = 0.00;
            if ($rule->additional > 0) {
                $additional = $total - $rule->first; // 剩余件数/重量

                // 没有超出续件阈值，首件+续件费用
                if ($additional <= $rule->additional) {
                    $additional_fee = $rule->additional_fee;
                } else { // 超出续件阈值
                    $additional_fee = bcdiv($rule->additional_fee, $rule->additional, 2) * $additional;
                }
            }
            return $rule->first_fee + $additional_fee;
        }
        return null;
    }

    public static function detail(int $id)
    {
        return self::with('item')->findOrFail($id);
    }
}
