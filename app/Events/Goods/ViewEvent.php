<?php

namespace App\Events\Goods;

use App\Logics\Api\Goods;
use Illuminate\Queue\SerializesModels;

/**
 * 前端查看商品详细
 * Class ViewEvent
 * @package App\Events\FenxiaoGoods
 */
class ViewEvent
{
    use SerializesModels;

    public $goods;

    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
    }
}
