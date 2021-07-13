<?php

return [
    [
        'module_name'   => '活动设置',
        'server_router' => '',
        'client_router' => '/addon/newcomer/index',
        'redirect'      => '',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
        'children'      => [
            [
                'module_name'   => '查看',
                'server_router' => 'newcomer.index',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '保存',
                'server_router' => 'newcomer.submit',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
        ],
    ],
];
