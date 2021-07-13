<?php

namespace App\Logics\Web;

use App\Models\Goods as GoodsModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Log;
use DB;

class Goods extends GoodsModel
{
    public static function getList()
    {
        $request    = Request::capture();
        $filter     = [];
        $order      = 'sort asc';
        $status     = $request->get('status');
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

        switch ($status) {
            case 1: // 销售中
                $filter[] = ['status', '=', self::STATUS_ON];
                $filter[] = ['stock', '>', 0];
                break;
            case 2: // 仓库中
                $filter[] = ['status', '=', self::STATUS_OFF];
                break;
            case 3: // 已售罄
                $filter[] = ['status', '=', self::STATUS_ON];
                $filter[] = ['stock', '=', 0];
                break;
            case 4: // 回收站
                return self::onlyTrashed()
                    ->where($filter)
                    ->orderByRaw($order)
                    ->paginate(
                        $request->get('limit', self::PAGE)
                    );
        }

        return self::where($filter)
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
            ->with('category')
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['category', 'group', 'support', 'images'])->findOrFail($id);
    }

    public static function getImages(int $id)
    {
        return self::with('images')
            ->select(['id', 'image'])
            ->findOrFail($id);
    }

    public static function getSale(int $id)
    {
        $detail = self::with('sku.value.specValue')->findOrFail($id);
        $value  = self::with(['specValue.spec'])->findOrFail($id);
        $spec   = [];
        $spec_value = [];

        foreach ($value->specValue as $item) {
            $spec[$item->spec->id]['id']      = $item->spec->id;
            $spec[$item->spec->id]['name']    = $item->spec->name;

            if (!isset($spec_value[$item->id])) {
                $spec_value[$item->id] = true;
                $spec[$item->spec->id]['value'][] = [
                    'id'   => $item->id,
                    'name' => $item->name,
                ];
            }
        }
        $detail->spec = array_values($spec);

        foreach ($detail->sku as $item) {
            foreach ($item->value as $subItem) {
                $subItem->name = $subItem->specValue->name;
            }
        }
        return $detail;
    }

    public static function add(array $data)
    {
        try {
            DB::beginTransaction();
            $data['goods_sn'] = get_sn();
            if ($model = self::create($data)) {
                $model->saveCategory($data);
                $model->saveImages($data);
                $model->saveGroup($data);
                $model->saveSupport($data);
                $model->saveSku($data);
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

    public static function edit(array $data)
    {
        try {
            DB::beginTransaction();
            $model = self::detail($data['id']);
            if ($model->fill($data)->save()) {
                $model->saveCategory($data);
                $model->saveImages($data);
                $model->saveGroup($data);
                $model->saveSupport($data);
                $model->saveSku($data);
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

    private function saveCategory(array $data)
    {
        if (isset($data['category'])) {
            $array = [];
            foreach ($data['category'] as $index => $id) {
                $array[$id] = ['level' => $index];
            }
            $this->category()->detach();
            $this->category()->attach($array);
        }
    }

    private function saveImages(array $data)
    {
        if (isset($data['image_list'])) {
            $this->images()->delete();
            $this->images()->saveMany(
                array_map(function ($value) {
                    return new GoodsImages(['name' => $value]);
                }, $data['image_list'])
            );
        }
    }

    private function saveGroup(array $data)
    {
        if (isset($data['group'])) {
            $this->group()->detach();
            $this->group()->attach($data['group']);
        }
    }

    private function saveSupport(array $data)
    {
        if (isset($data['support'])) {
            $this->support()->detach();
            $this->support()->attach($data['support']);
        }
    }

    private function saveSku(array $data)
    {
        if (isset($data['sku'])) {
            $this->sku()->delete();
            $this->skuValue()->delete();

            $stock       = 0; // 初始总库存
            $sales_price = $data['sku'][0]['sales_price']; // 初始销售价，用于比较最低价
            $line_price  = $data['sku'][0]['line_price']; // 初始划线价，用于比较最低价

            foreach ($data['sku'] as $item) {
                $stock      += $item['stock']; // 合计总库存
                $sales_price = $sales_price > $item['sales_price'] ? $item['sales_price'] : $sales_price; // 找出价格最低sku
                $line_price  = $line_price > $item['line_price'] ? $item['line_price'] : $line_price; // 找出价格最低sku

                // 保存Sku
                $sku = $this->sku()->save(
                    new GoodsSku([
                        'sku_sn'      => get_sn(),
                        'sku_code'    => $item['sku_code'] ?? '',
                        'sku_name'    => $item['sku_name'] ?? '',
                        'sales_price' => $item['sales_price'] ?? 0,
                        'line_price'  => $item['line_price'] ?? 0,
                        'cost_price'  => $item['cost_price'] ?? 0,
                        'weight'      => $item['weight'] ?? 0,
                        'volume'      => $item['volume'] ?? 0,
                        'stock'       => $item['stock'] ?? 0,
                        'level_one'   => $item['level_one'] ?? 0,
                        'level_two'   => $item['level_two'] ?? 0,
                    ])
                );

                if ($data['sku_type'] == self::SPEC_TYPE_MULTI) {
                    // 规格值列表
                    $spec_value_list = explode(':', $item['sku_code']);
                    // 保存sku value
                    foreach ($spec_value_list as $value) {
                        $spec_value = SpecValue::detail($value);
                        $sku->value()->save(
                            new GoodsSkuValue([
                                'goods_id'      => $this->id,
                                'spec_id'       => $spec_value->spec_id,
                                'spec_value_id' => $spec_value->id
                            ])
                        );
                    }
                }
            }
            $this->sales_price = $sales_price;
            $this->line_price  = $line_price;
            $this->stock       = $stock;
            $this->save();
        }
    }

    /**
     * 批量上下架
     * @param array $data
     * @return bool
     */
    public static function status(array $data)
    {
        return self::whereIn('id', explode(',', $data['id']))
                ->update(['status' => $data['value']]) >= 0;
    }

    /**
     * 恢复
     * @param string $id
     * @return bool
     */
    public static function recover(string $id)
    {
        $id = explode(',', $id);
        $result = self::withTrashed()->whereIn('id', $id)->restore();
        return $result >= 0;
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }

    /**
     * 彻底删除
     * @param string $id
     * @return bool
     * @throws \Exception
     */
    public static function forceRemove(string $id)
    {
        try {
            DB::beginTransaction();
            $list = self::withTrashed()->whereIn('id', explode(',', $id))->get();
            foreach ($list as $model) {
                $model->forceDelete();
                $model->images()->forceDelete();
                $model->sku()->forceDelete();
                $model->skuValue()->forceDelete();
                $model->comment()->forceDelete();
                $model->favorite()->forceDelete();
                $model->history()->forceDelete();
                $model->category()->detach();
                $model->group()->detach();
                $model->support()->detach();
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

    public static function addSpec(string $name)
    {
        return Spec::with('value')->firstOrCreate(['name' => $name]);
    }

    public static function addSpecValue(int $spec_id, string $name)
    {
        return SpecValue::firstOrCreate(
            ['spec_id' => $spec_id, 'name' => $name],
            ['spec_id' => $spec_id, 'name' => $name]
        );
    }

    public static function batchCategory(array $data)
    {
        try {
            DB::beginTransaction();
            $list = self::whereIn('id', explode(',', $data['id']))->get();
            foreach ($list as $item) {
                $item->saveCategory($data);
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
}
