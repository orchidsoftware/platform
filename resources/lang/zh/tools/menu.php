<?php

return [
    'title'       => '菜单',
    'description' => '选择一个可访问菜单',

    'not_found' => '没有可见菜单',
    'form'      => [
        'title'             => '标题',
        'title_description' => '关于我们',
        'alt'               => '别名',
        'alt_description'   => '公司历史',
        'url'               => 'URL',
        'url_description'   => 'URL描述',
        'display'           => [
            'name'      => '显示',
            'variables' => [
                'no_auth' => '所有人可见',
                'auth'    => '只限权限用户',
            ],
        ],
        'class'             => 'Class',
        'relations'         => [
            'name'      => '关系',
            'variables' => [
                'answer'     => '回答问题',
                'chapter'    => '选择当前章节',
                'co-worker'  => "同事主面",
                'colleague'  => "同伴主面 (非工作)",
                'contact'    => '联系信息',
                'details'    => '详情',
                'edit'       => '可编辑当前文本版本',
                'friend'     => '朋友页面',
                'question'   => '问题',
                'archives'   => '网站文章',
                'author'     => '作者其他域名',
                'bookmark'   => '标签页',
                'first'      => '主页',
                'help'       => '帮助',
                'index'      => '内容',
                'last'       => '最后一页',
                'license'    => '许可协议或版权',
                'me'         => '作者主页',
                'next'       => '下一页',
                'nofollow'   => 'Do not pass on the link TIC and PR.',
                'noreferrer' => '不通过HTTP头的链接',
                'prefetch'   => '表明你必须事先指定缓存资源',
                'prev'       => '上一页',
                'search'     => '搜索',
                'sidebar'    => '添加到收藏',
                'tag'        => '相关标签',
                'up'         => '向上',
            ],
        ],
        'target'            => [
            'name'      => '链接目标',
            'variables' => [
                'self'  => '当前窗口打开',
                'blank' => '打开链接到新窗口',
            ],
        ],
        'control'           => [
            'remove' => '删除',
            'reset'  => '重置',
            'create' => '创建',
            'save'   => '保存',
        ],
    ],
];
