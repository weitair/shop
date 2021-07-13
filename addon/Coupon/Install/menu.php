<?php

return [
    [
        'module_name'   => '数据',
        'server_router' => 'coupon.index',
        'client_router' => '/addon/coupon/index',
        'redirect'      => '',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
    ],
    [
        'module_name'   => '优惠卷',
        'server_router' => '',
        'client_router' => '/addon/coupon/coupon',
        'redirect'      => '/addon/coupon/coupon/list',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
        'children'      => [
            [
                'module_name'   => '列表',
                'server_router' => 'coupon.list',
                'client_router' => '/addon/coupon/coupon/list',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '添加',
                'server_router' => 'coupon.add',
                'client_router' => '/addon/coupon/coupon/add',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '编辑',
                'server_router' => 'coupon.edit',
                'client_router' => '/addon/coupon/coupon/edit',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '发卷',
                'server_router' => 'coupon.push',
                'client_router' => '/addon/coupon/coupon/push',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '删除',
                'server_router' => 'coupon.remove',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
        ],
    ],
    [
        'module_name'   => '领取记录',
        'server_router' => '',
        'client_router' => '/addon/coupon/receive',
        'redirect'      => '/addon/coupon/receive/list',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
        'children'      => [
            [
                'module_name'   => '列表',
                'server_router' => 'coupon/receive.list',
                'client_router' => '/addon/coupon/receive/list',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '删除',
                'server_router' => 'coupon/receive.remove',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
        ],
    ],
];
