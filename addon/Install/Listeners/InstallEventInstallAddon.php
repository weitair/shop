<?php

namespace Addon\Install\Listeners;

use Addon\Install\Events\InstallEvent;
use File;
use Str;
use DB;

class InstallEventInstallAddon
{
    public function handle(InstallEvent $event)
    {
        $params = $event->params;

        $path = base_path('addon');
        $dirs = File::directories($path);

        foreach ($dirs as $path) {
            if (!Str::contains($path, 'Install')) {
                $install_path = $path . '/' . 'Install';
                $database     = File::get($install_path . '/database.sql');
                $base         = include($install_path . '/base.php');
                $menu         = include($install_path . '/menu.php');

                // 导入数据
                preg_match_all("/Create table .*\(.*\).*\;/iUs", $database, $list);
                foreach ($list[0] as $item) {
                    DB::statement($item);
                }

                preg_match_all("/INSERT INTO .*\(.*\).*\;/iUs", $database, $list);
                foreach ($list[0] as $item) {
                    DB::statement($item);
                }

                // 处理插件数据
                if (DB::table('addon')->where('key', $base['key'])->first()) {
                    DB::table('addon')->where('key', $base['key'])->update([
                        'install' => 1
                    ]);
                } else {
                    $base['install'] = 1;
                    DB::table('addon')->insert($base);
                }

                // 处理菜单数据
                $parent['module_name']   = $base['name'];
                $parent['addon_key']     = $base['key'];
                $parent['client_router'] = $base['router'];
                $parent['type']          = 1;
                $parent['level']         = 1;
                $parent['hidden']        = 1;
                $parent['parent_id']     = 3;

                if ($parent_id = $this->add($parent)) {
                    $root = $parent_id;
                    $this->addModule($menu, $parent_id, 2, $root);
                }
            }
        }
        // 菜单添加到角色中
        $root = 3;
        $list = DB::table('module')->get();
        $this->addRoleModule($list, $root);
    }

    private function addRoleModule(object $list, int $parent)
    {
        foreach ($list as $item) {
            if ($item->parent_id == $parent) {
                DB::table('role_module')->insert([
                    'role_id'   => 1,
                    'module_id' => $item->id,
                ]);

                $this->addRoleModule($list, $item->id);
            }
        }
    }

    private function addModule(array $menu, int $parent, int $level, int $root)
    {
        if ($level == 2) $parent = $root;

        foreach ($menu as $key => $item) {
            $item['parent_id'] = $parent;
            $item['level']     = $level;
            $item['sort']      = $key;

            if (isset($item['children']) && count($item['children'])) {
                $children = $item['children'];
                unset($item['children']);

                $parent_id = $this->add($item);
                $this->addModule($children, $parent_id, $level + 1, $root);
            } else {
                $this->add($item);
            }
        }
    }

    private function add(array $data)
    {
        return DB::table('module')->insertGetId($data);
    }
}
