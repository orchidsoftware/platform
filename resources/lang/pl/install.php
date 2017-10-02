<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Instalator Orchid',
    'next'          => 'Następny krok',
    'finish'        => 'Zainstalować',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => 'Witamy instalatora',
        'message' => 'Witamy w kreatorze konfiguracji.',
        'body'    => 'Podstawowy proces instalacji Orchid jest taki sam jak dla większości aplikacji Laravel. Instalator wywołuje komendy Artisan do instalowania migracji i powiązanych składników. Instalator koordynuje proces instalacji od początku do końca.',
        'footer'  => 'Staramy się uprościć instalację komponentu programu jednym kliknięciem. Jesteśmy dumni, że jest to prosty i skuteczny instalator niż kiedykolwiek wcześniej.',

    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements'  => [
        'title'      => 'Wymagania',
        'message'    => 'Sprawdzanie zainstalowanych modułów PHP',
        'extensions' => [
            'openssl'    => 'OpenSSL PHP Rozbudowa',
            'pdo'        => 'PDO PHP Rozbudowa',
            'mbstring'   => 'Mbstring PHP Rozbudowa',
            'tokenizer'  => 'Tokenizer PHP Rozbudowa',
            'zip'        => 'ZIP Archive PHP Rozbudowa',
            'xml'        => 'XML PHP Rozbudowa',
            'json'       => 'JSON PHP Rozbudowa',
            'bd_connect' => 'Połączenia z bazą danych',

        ],
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions'   => [
        'title'   => 'Uprawnienia',
        'message' => 'Wymagane do odczytu i zapisu plików',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => 'Konfiguracja środowiska',
        'message' => 'Stałe i podstawowe ustawienia, które nie podlegają zmianom',
        'save'    => 'Zapisać .env',
        'success' => 'Twoje ustawienia plików .env zostały zapisane.',
        'errors'  => 'Nie można zapisać pliku .env, proszę utworzyć go ręcznie.',
    ],

    /*
  *
  * Administrator page translations.
  *
  */
    'administrator' => [
        'title'   => 'Tworzenie użytkownika',
        'message' => 'Created by the administrator will be available to all right at the moment',
        'help'    => 'Later you can create using the artisan command',
    ],

    'install' => 'Zainstalować',

    /*
     *
     * Final page translations.
     *
     */
    'final'   => [
        'title'   => 'Skończone',
        'message' => 'Aplikacja została pomyślnie zainstalowana.',
        'exit'    => 'Kliknij tutaj, aby zakończyć',
    ],
];
