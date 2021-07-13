<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Cart;
use App\Logics\Api\Goods;
use App\Models\OrderComment;
use App\Logics\Api\GoodsCategory;
use App\Logics\Api\GoodsFavorite;

class GoodsController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'category' => GoodsCategory::getList(),
            'list' => Goods::getList()
        ]);
    }

    public function list()
    {
        $this->renderSuccess(
            Goods::getList()
        );
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $id               = $this->request->get('id');
        $detail           = Goods::detail($id);
        $detail->favorite = GoodsFavorite::isFavorite($id);
        $detail->cart     = Cart::getCount();

        $spec       = $detail->spec;
        $spec_value = $detail->specValue;
        $spec_list  = [];
        foreach ($spec as $item) {
            $spec_list[$item['id']] = [
                'id'   => $item['id'],
                'name' => $item['name']
            ];
            foreach ($spec_value as $sub_item) {
                $spec_list[$sub_item['spec_id']]['children'][$sub_item['id']] = [
                    'id'   => $sub_item['id'],
                    'name' => $sub_item['name']
                ];
            }
        }
        $spec_list = array_values($spec_list);
        foreach ($spec_list as $key => $item) {
            $spec_list[$key]['children'] = array_values($item['children']);
        }
        unset($detail->spec);
        unset($detail->specValue);
        $detail->spec = $spec_list;

        $this->renderSuccess($detail);
    }

    public function favorite()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsFavorite::change($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function comment()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $filter[]        = ['goods_id', '=', $this->request->get('id')];
        $filter[]        = ['status', '=', OrderComment::STATUS_PASS];
        $label['praise'] = OrderComment::where($filter)->where('satisfaction', OrderComment::SATISFACTION_PRAISE)->count();
        $label['middle'] = OrderComment::where($filter)->where('satisfaction', OrderComment::SATISFACTION_MIDDLE)->count();
        $label['fail']   = OrderComment::where($filter)->where('satisfaction', OrderComment::SATISFACTION_FAIL)->count();
        $label['image']  = OrderComment::where($filter)->where('image_status', 1)->count();

        $this->renderSuccess([
            'label' => $label,
            'list'  => Goods::comments()
        ]);
    }

    public function commentList()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(Goods::comments());
    }

    public function poster()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(Goods::poster());
    }
}
