<?php

return [

    'Monitor'     => 'Монитор',
    'description' => 'Информация о состоянии сервера',
    'disabled'    => 'Операционная система или настройки PHP не поддерживаются монитором',

    'Hardware'         => [
        'Title'             => 'Аппаратное обеспечение',
        'Uptime'            => 'Время работы',
        'Board Temperature' => 'Тепература',
    ],
    'Network'          => [
        'Title' => 'Сеть',
        'Down'  => 'Отдачи',
        'Up'    => 'Скачивания',
    ],
    'CPU Load Average' => [
        'Title' => 'Процессор',
        'min'   => 'минут',
    ],
    'Memory'           => [
        'Title'   => 'Память',
        'Used'    => 'Занято',
        'Cache'   => 'Кэш',
        'Buffers' => 'Временное',
        'Free'    => 'Свободно',
    ],
    'Storage'          => [
        'Title'      => 'Жёсткие диски',
        'FILESYSTEM' => 'ФАЙЛОВАЯ СИСТЕМА',
        'AVAILABLE'  => 'ДОСТУПНО',
        'Size'       => 'Размер',
        'USED'       => 'ЗАНЯТО',
        'MOUNTED'    => 'ПОДКЛЮЧЕНО',
    ],
    'Info'             => [
        'Title'       => 'Информация',
        'Linux'       => 'ОС',
        'Web Server'  => 'Веб-сервер',
        'PHP Version' => 'PHP Версия',
        'CPU'         => 'Процессор',
    ],
];
