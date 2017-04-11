<?php

return [

    'Monitor'     => 'Monitor',
    'description' => 'Server Status Information',
    'disabled'    => 'The operating system or PHP settings are not supported by the monitor',

    'Hardware'         => [
        'Title'             => 'Hardware',
        'Uptime'            => 'Uptime',
        'Board Temperature' => 'Board Temperature',
    ],
    'Network'          => [
        'Title' => 'Network',
        'Down'  => 'Down',
        'Up'    => 'Up',
    ],
    'CPU Load Average' => [
        'Title' => 'CPU Load Average',
        'min'   => 'min',
    ],
    'Memory'           => [
        'Title'   => 'Memory',
        'Used'    => 'Used',
        'Cache'   => 'Cache',
        'Buffers' => 'Buffers',
        'Free'    => 'Free',
    ],
    'Storage'          => [
        'Title'      => 'Storage',
        'FILESYSTEM' => 'FILESYSTEM',
        'AVAILABLE'  => 'AVAILABLE',
        'Size'       => 'Size',
        'USED'       => 'USED',
        'MOUNTED'    => 'MOUNTED',
    ],
    'Info'             => [
        'Title'       => 'Info',
        'Linux'       => 'Linux',
        'Web Server'  => 'Web Server',
        'PHP Version' => 'PHP Version',
        'CPU'         => 'CPU',
    ],
];
