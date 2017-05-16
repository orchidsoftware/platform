<?php

return [

    'Monitor'     => '监控',
    'description' => '服务器状态信息',
    'disabled'    => '显示器不支持操作系统或PHP设置',

    'Hardware'         => [
        'Title'             => '硬件',
        'Uptime'            => '正常运行时间',
        'Board Temperature' => '板温度',
    ],
    'Network'          => [
        'Title' => '网络',
        'Down'  => '下',
        'Up'    => '向上',
    ],
    'CPU Load Average' => [
        'Title' => 'CPU负载平均',
        'min'   => '分',
    ],
    'Memory'           => [
        'Title'   => '记忆',
        'Used'    => '用过的',
        'Cache'   => '高速缓存',
        'Buffers' => '缓冲区',
        'Free'    => '自由',
    ],
    'Storage'          => [
        'Title'      => '存储',
        'FILESYSTEM' => '文件系统',
        'AVAILABLE'  => '可用',
        'Size'       => '尺寸',
        'USED'       => '用过的',
        'MOUNTED'    => '安装',
    ],
    'Info'             => [
        'Title'       => '信息',
        'Linux'       => 'Linux',
        'Web Server'  => '网络服务器',
        'PHP Version' => 'PHP版本',
        'CPU'         => '中央处理器',
    ],
];
