<?php

return [

    'Monitor'     => 'Монітор',
    'description' => 'Інформація про стан сервера',
    'disabled'    => 'Операційна система або настройки PHP не підтримуються монітором',

    'Hardware'         => [
        'Title'             => 'Апаратне забезпечення',
        'Uptime'            => 'Час роботи',
        'Board Temperature' => 'Тепература',
    ],
    'Network'          => [
        'Title' => 'Мережа',
        'Down'  => 'Віддачі',
        'Up'    => 'Скачування',
    ],
    'CPU Load Average' => [
        'Title' => 'Процесор',
        'min'   => 'хвилин',
    ],
    'Memory'           => [
        'Title'   => "Пам'ять",
        'Used'    => 'Зайнято',
        'Cache'   => 'Кеш',
        'Buffers' => 'Тимчасовий',
        'Free'    => 'Вільно',
    ],
    'Storage'          => [
        'Title'      => 'Жорсткі диски',
        'FILESYSTEM' => 'ФАЙЛОВАЯ СИСТЕМА',
        'AVAILABLE'  => 'ДОСТУПНО',
        'Size'       => 'Розмір',
        'USED'       => 'ЗАНЯТО',
        'MOUNTED'    => 'ПІДКЛЮЧЕНО',
    ],
    'Info'             => [
        'Title'       => 'Інформація',
        'Linux'       => 'ОС',
        'Web Server'  => 'Веб-сервер',
        'PHP Version' => 'PHP Версія',
        'CPU'         => 'Процессор',
    ],
];
