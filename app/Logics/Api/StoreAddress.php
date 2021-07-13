<?php

namespace App\Logics\Api;

use App\Models\StoreAddress as StoreAddressModel;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class StoreAddress extends StoreAddressModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    /**
     * 根据用户坐标返回最近距离的发货点
     * @param string $memberLon
     * @param string $memberLat
     * @return mixed
     */
    public static function getShipmentMinDistance(string $memberLon, string $memberLat)
    {
        $result = [];

        // 商家地址库中所有的可发货地址
        $list = self::where('is_shipment', self::SHIPMENT_ON)->where('status', self::STATUS_ON)->get();

        foreach ($list as $item) {
            // 发货点经纬度
            $storeLon = $item->lon;
            $storeLat = $item->lat;

            // 两点相隔的距离(km)
            $result[] = get_distance($storeLon, $storeLat, $memberLon, $memberLat);
        }
        return count($result) > 0 ? min($result) : 0;
    }

    /**
     * 根据用户坐标返回自提点并带相隔距离
     * @param string $memberLon
     * @param string $memberLat
     * @return mixed
     */
    public static function getFetchStore(string $memberLon, string $memberLat)
    {
        // 商家地址库中所有的自提地址
        $list = self::where('is_fetch', self::FETCH_ON)->where('status', self::STATUS_ON)->get();

        foreach ($list as $item) {
            // 发货点经纬度
            $storeLon = $item->lon;
            $storeLat = $item->lat;

            // 两点相隔的距离(km)
            $item->distance = get_distance($storeLon, $storeLat, $memberLon, $memberLat);
        }
        return $list;
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }
}
