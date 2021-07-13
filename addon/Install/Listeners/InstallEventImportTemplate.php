<?php

namespace Addon\Install\Listeners;

use Addon\Install\Events\InstallEvent;
use File;
use DB;

class InstallEventImportTemplate
{
    public function handle(InstallEvent $event)
    {
        $params = $event->params;

        $path     = public_path('assets/uniapp/template/1/template.json');
        $template = File::get($path);

        // 插入模板数据
        $data['title']   = '微态尔商城';
        $data['header']  = '{"page_name":"微态尔商城","page_color":"#ffffff","page_skin":"#D33F3D"}';
        $data['content'] = str_replace('{{WEITAIR_ROOT}}', $params['root'], $template);
        $data['home']    = 1;
        $data['status']  = 1;

        DB::table('page')->insert($data);
    }
}
