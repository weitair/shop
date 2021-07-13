<?php

namespace App\Http\Controllers\Web;

use App\Helper\Tree;
use App\Models\Addon;
use App\Models\Link;

class IndexController extends Controller
{
    public function addon()
    {
        $list = Addon::with('module')->get();
        $this->renderSuccess($list);
    }

    public function link()
    {
        $list = Link::orderBy('sort', 'asc')->get()->toArray();
        $max  = Link::max('id') + 1;
        $list = Tree::make($list);
        $addon = Addon::select('name', 'app_path')->where('install', 1)->where('app_path', '<>', '')->orderBy('sort')->get();
        $addon_list = [];
        $id = $max;
        foreach ($addon as $item) {
            $addon_list[] = [
                'id'        => ++$id,
                'parent_id' => $max,
                'name'      => $item->name,
                'path'      => $item->app_path,
            ];
        }
        if (count($addon_list)) {
            $list[] = [
                'id'        => $max,
                'parent_id' => 0,
                'name'      => '插件链接',
                'children'  => $addon_list
            ];
        }
        $this->renderSuccess($list);
    }
}
