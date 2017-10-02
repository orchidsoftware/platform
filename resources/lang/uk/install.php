<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Установка Orchid',
    'next'          => 'Наступний крок',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => 'Установка Orchid',
        'message' => 'Ласкаво просимо в початкові установки фреймворка.',
        'body'    => 'Основний процес установки Orchid є таким же, як для більшості додатків на базі Laravel. Програма установки викликає команди Artisan для установки міграцій і пов\'язаних компонентів. Налаштування координує процес установки від початку до кінця.',
        'footer'  => 'Ми намагаємося спростити установку компонента програми в один клік. Ми сподіваємось, що це простий і ефективний устновщік, ніж будь-коли раніше.',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements'  => [
        'title'      => 'Необхідні модулі',
        'message'    => 'Перевірка встановлених модулів PHP',
        'extensions' => [
            'openssl'    => 'OpenSSL PHP Extension',
            'pdo'        => 'PDO PHP Extension',
            'mbstring'   => 'Mbstring PHP Extension',
            'tokenizer'  => 'Tokenizer PHP Extension',
            'zip'        => 'ZIP Archive PHP Extension',
            'xml'        => 'XML PHP Extension',
            'json'       => 'JSON PHP Extension',
            'bd_connect' => 'Підключення до бази даних',
        ],
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions'   => [
        'title'   => 'Перевірка прав на папках',
        'message' => 'Необхідні для читання і запису файлів',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => 'Налаштування оточення',
        'message' => 'Постійні і основний настройки, зміст яких не повинен зміною',
        'save'    => 'Зберегти .env',
        'success' => 'Налаштування успішно збережені в файлі .env',
        'errors'  => 'Сталася помилка при збереженні файлу .env, будь ласка, збережіть його вручну',
    ],

    /*
    *
    * Administrator page translations.
    *
    */
    'administrator' => [
        'title'   => 'Створення користувача',
        'message' => 'Створеному адміністратору будуть доступні всі права на поточний момент',
        'help'    => 'Пізніше можна створити за допомогою artisan команди',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final'         => [
        'title'   => 'Готово',
        'message' => 'Додаток успішно налаштовано.',
        'exit'    => 'Натисніть для виходу',
    ],
];
