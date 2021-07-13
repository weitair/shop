<?php

namespace App\Http\Controllers\Web\Goods;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\GoodsCategory;
use App\Logics\Web\GoodsSupport;
use App\Logics\Web\GoodsGroup;
use App\Logics\Web\Template;
use App\Logics\Web\Goods;
use App\Logics\Web\Unit;
use App\Logics\Web\Spec;

class GoodsController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'category' => GoodsCategory::getList(),
            'group'    => GoodsGroup::getAll(),
            'list'     => Goods::getList(),
        ]);
    }

    public function list()
    {
        $this->renderSuccess(Goods::getList());
    }

    public function add()
    {
        $this->renderSuccess([
            'category' => GoodsCategory::getList(),
            'group'    => GoodsGroup::getAll(),
            'support'  => GoodsSupport::getAll(),
            'unit'     => Unit::getAll(),
            'spec'     => Spec::getAll(),
            'sort'     => Goods::getMaxSort(),
            'template' => Template::getAll()
        ]);
    }

    public function addSubmit()
    {
        $this->validate([
            'goods_name'      => 'required|string',
            'image'           => 'required|string',
            'image_list'      => 'required|array',
            'sku_type'        => 'required|int',
            'sku'             => 'required|array',
            'logistics_unite' => 'required|int',
            'category'        => 'required|array',
            'group'           => 'array',
            'support'         => 'array',
            'content'         => 'string',
        ]);

        if (Goods::add($data = $this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function edit()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'category' => GoodsCategory::getList(),
            'group'    => GoodsGroup::getAll(),
            'support'  => GoodsSupport::getAll(),
            'unit'     => Unit::getAll(),
            'detail'   => Goods::detail($this->request->get('id'))
        ]);
    }

    public function editSubmit()
    {
        $this->validate([
            'id'         => 'required|int',
            'category'   => 'required|array',
            'goods_name' => 'required|string',
            'group'      => 'array',
            'support'    => 'array',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function content()
    {
        $this->renderSuccess(
            Goods::detail($this->request->get('id'))
        );
    }

    public function contentSubmit()
    {
        $this->validate([
            'id'         => 'required|int',
            'image'      => 'required|string',
            'image_list' => 'required|array',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sale()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'spec'   => Spec::getAll(),
            'detail' => Goods::getSale($this->request->get('id'))
        ]);

        $this->renderSuccess(
            Goods::getSale($this->request->get('id'))
        );
    }

    public function saleSubmit()
    {
        $this->validate([
            'id'  => 'required|int',
            'sku' => 'required|array',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function logistics()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'template' => Template::getAll(),
            'detail'   => Goods::detail($this->request->get('id'))
        ]);
    }

    public function logisticsSubmit()
    {
        $this->validate([
            'id'              => 'required|int',
            'logistics_unite' => 'required|int',
        ]);

        if (Goods::edit($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function other()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(Goods::detail($this->request->get('id')));
    }

    public function otherSubmit()
    {
        $this->validate([
            'id'         => 'required|int',
            'sort'       => 'required|int',
            'status'     => 'required|int',
        ]);

        $data = $this->request->all();
        $data['sales_time'] = empty($data['sales_time']) ? '' : $data['sales_time'];

        if (Goods::edit($data)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function statusSubmit()
    {
        $this->validate([
            'id'    => 'required|string',
            'value' => 'required|int',
        ]);

        if (Goods::status($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function sortSubmit()
    {
        $this->validate([
                'id'    => 'required|int',
                'value' => 'required|int',
        ]);

        $id = $this->request->get('id');
        $value = $this->request->get('value');
        if (Goods::setSort($id, $value)) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function recoverSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Goods::recover($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Goods::remove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function forceRemoveSubmit()
    {
        $this->validate([
            'id' => 'required|string',
        ]);

        if (Goods::forceRemove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function specSubmit()
    {
        $this->validate([
            'name' => 'required|string',
        ]);

        if ($result = Goods::addSpec($this->request->post('name'))) {
            $this->renderSuccess($result, '操作成功');
        }
        $this->renderError($result, '操作失败');
    }

    public function specValueSubmit()
    {
        $this->validate([
            'spec_id' => 'required|int',
            'name' => 'required|string',
        ]);

        $spec_id = $this->request->post('spec_id');
        $name = $this->request->post('name');
        if ($result = Goods::addSpecValue($spec_id, $name)) {
            $this->renderSuccess($result, '操作成功');
        }
        $this->renderError($result, '操作失败');
    }

    /**
     * 批量分类
     */
    public function category()
    {
        $this->renderSuccess(GoodsCategory::getList());
    }

    public function categorySubmit()
    {
        $this->validate([
            'id'       => 'required|string',
            'category' => 'required|array',
        ]);

        if (Goods::batchCategory($this->request->post())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
