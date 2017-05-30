<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Установка Orchid',
    'next'          => 'Следующий шаг',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => 'Установка Orchid',
        'message' => 'Добро пожаловать в первоначальную настройку фреймворка.',
        'body'    => 'Основной процесс установки Orchid является таким же, как для большинства приложений на базе Laravel. Программа установки вызывает команды Artisan для установки миграций и связанных компонентов. Настройка координирует процесс установки от начала до конца.',
        'footer'  => 'Мы стараемся упростить установку компонента программы в один клик. Мы надемся, что это простой и эффективный устновщик, чем когда-либо прежде.',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements'  => [
        'title'      => 'Необходимые модули',
        'message'    => 'Проверка установленных модулей PHP',
        'extensions' => [
            'openssl'    => 'OpenSSL PHP Extension',
            'pdo'        => 'PDO PHP Extension',
            'mbstring'   => 'Mbstring PHP Extension',
            'tokenizer'  => 'Tokenizer PHP Extension',
            'zip'        => 'ZIP Archive PHP Extension',
            'xml'        => 'XML PHP Extension',
            'json'       => 'JSON PHP Extension',
            'bd_connect' => 'Подключение к базе данных',
        ],
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions'   => [
        'title'   => 'Проверка прав на папках',
        'message' => 'Необходимы для чтения и записи файлов',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => 'Настройки окружения',
        'message' => 'Постоянные и основный настройки, которые не подвергаются изменением',
        'save'    => 'Сохранить .env',
        'success' => 'Настройки успешно сохранены в файле .env',
        'errors'  => 'Произошла ошибка при сохранении файла .env, пожалуйста, сохраните его вручную',
    ],

    /*
    *
    * Administrator page translations.
    *
    */
    'administrator' => [
        'title'   => 'Создание пользователя',
        'message' => 'Созданному администратору будут доступные все права на текущий момент',
        'help'    => 'Позднее можно создать с помощью artisan команды',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final'         => [
        'title'   => 'Готово',
        'message' => 'Приложение успешно настроено.',
        'exit'    => 'Нажмите для выхода',
    ],
];
