<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    const PAGE = 20; // 默认每页显示记录数

    // 来源渠道(0：公众号、1：小程序、2：H5)
    const CHANNEL_WECHAT     = 0;
    const CHANNEL_WECHAT_APP = 1;
    const CHANNEL_H5         = 2;

    protected $filter = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * 获取最大排序数字并 +1
     * @return int
     */
    public static function getMaxSort()
    {
        $max = self::max('sort');
        return $max == 0 ? 1 : $max + 1;
    }

    public static function setSort(int $id, int $value)
    {
        $model = self::find($id);
        $model->sort = $value;
        return $model->save();
    }

    /**
     * 根据查询提交数据，获取查询条件数组
     */
//    protected function getQuery()
//    {
//        $request = Request::capture();
//        $fields = $request->all();
//
//        foreach ($fields as $key => $item) {
//            $method = 'query' . ucfirst(Str::camel($key));
//            if (method_exists($this, $method)) {
//                $this->{$method}($item);
//            }
//        }
//    }
}
