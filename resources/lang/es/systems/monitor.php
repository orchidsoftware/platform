<?php

return [

    'Monitor'     => 'Monitor',
    'description' => 'Información del estado del servidor',
    'disabled'    => 'El sistema operativo o la configuración de PHP no son compatibles con el monitor',

    'Hardware'         => [
        'Title'             => 'Hardware',
        'Uptime'            => 'Tiempo de actividad',
        'Board Temperature' => 'Temperatura del tablero',
    ],
    'Network'          => [
        'Title' => 'Red',
        'Down'  => 'Abajo',
        'Up'    => 'Arriba',
    ],
    'CPU Load Average' => [
        'Title' => 'CPU carga promedio',
        'min'   => 'Min',
    ],
    'Memory'           => [
        'Title'   => 'Memoria',
        'Used'    => 'Usado',
        'Cache'   => 'Cache',
        'Buffers' => 'Amortiguadores',
        'Free'    => 'Gratis',
    ],
    'Storage'          => [
        'Title'      => 'Almacenamiento',
        'FILESYSTEM' => 'SISTEMA DE ARCHIVOS',
        'AVAILABLE'  => 'DISPONIBLE',
        'Size'       => 'tamaño',
        'USED'       => 'USADO',
        'MOUNTED'    => 'MONTADO',
    ],
    'Info'             => [
        'Title'       => 'Información',
        'Linux'       => 'Linux',
        'Web Server'  => 'Servidor web',
        'PHP Version' => 'Versión de PHP',
        'CPU'         => 'CPU',
    ],
];
