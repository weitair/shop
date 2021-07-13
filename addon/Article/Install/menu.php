<?php

return [
    [
        'module_name'   => '文章',
        'server_router' => '',
        'client_router' => '/addon/article/index',
        'redirect'      => '/addon/article/index/list',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
        'children'      => [
            [
                'module_name'   => '列表',
                'server_router' => 'article.list',
                'client_router' => '/addon/article/index/list',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '添加',
                'server_router' => 'article.add',
                'client_router' => '/addon/article/index/add',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '编辑',
                'server_router' => 'article.edit',
                'client_router' => '/addon/article/index/edit',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '删除',
                'server_router' => 'article.remove',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
        ],
    ],

    [
        'module_name'   => '分类',
        'server_router' => '',
        'client_router' => '/addon/article/category',
        'redirect'      => '/addon/article/category/list',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
        'children'      => [
            [
                'module_name'   => '列表',
                'server_router' => 'article/category.list',
                'client_router' => '/addon/article/category/list',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '添加',
                'server_router' => 'article/category.add',
                'client_router' => '/addon/article/category/add',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '编辑',
                'server_router' => 'article/category.edit',
                'client_router' => '/addon/article/category/edit',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '删除',
                'server_router' => 'article/category.remove',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
        ],
    ],

    [
        'module_name'   => '横幅',
        'server_router' => '',
        'client_router' => '/addon/article/banner',
        'redirect'      => '/addon/article/banner/list',
        'icon'          => '',
        'type'          => 1, // 类型(0：目录、1：菜单、2：权限)
        'children'      => [
            [
                'module_name'   => '列表',
                'server_router' => 'article/banner.list',
                'client_router' => '/addon/article/banner/list',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '添加',
                'server_router' => 'article/banner.add',
                'client_router' => '/addon/article/banner/add',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '编辑',
                'server_router' => 'article/banner.edit',
                'client_router' => '/addon/article/banner/edit',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
            [
                'module_name'   => '删除',
                'server_router' => 'article/banner.remove',
                'client_router' => '',
                'redirect'      => '',
                'icon'          => '',
                'type'          => 2, // 类型(0：目录、1：菜单、2：权限)
            ],
        ],
    ],
];
