<?php

namespace Addon\Article\Logics\Api;

use Addon\Article\Models\ArticleBanner as ArticleBannerModel;
use Illuminate\Database\Eloquent\Builder;

class ArticleBanner extends ArticleBannerModel
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function getList()
    {
        return self::select(['title', 'image', 'redirect'])
            ->orderBy('sort', 'asc')->get();
    }
}
