<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Orchid Installer',
    'next'          => 'Next Step',
    'finish'        => 'Install',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => 'Welcome To The Installer',
        'message' => 'Welcome to the setup wizard.',
        'body'    => 'The basic installation process for Orchid is the same as for most Laravel based applications. The installer calls the Artisan commands to install migrations and related components. Setup coordinates the installation process from start to finish.',
        'footer'  => 'We try to simplify the installation of the program component in one click. We are proud that this is a simple and effective installer than ever before.',

    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements'  => [
        'title'      => 'Requirements',
        'message'    => 'Checking the installed PHP modules',
        'extensions' => [
            'openssl'    => 'OpenSSL PHP Extension',
            'pdo'        => 'PDO PHP Extension',
            'mbstring'   => 'Mbstring PHP Extension',
            'tokenizer'  => 'Tokenizer PHP Extension',
            'zip'        => 'ZIP Archive PHP Extension',
            'xml'        => 'XML PHP Extension',
            'json'       => 'JSON PHP Extension',
            'bd_connect' => 'Connecting to the database',
        ],
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions'   => [
        'title'   => 'Permissions',
        'message' => 'Required for reading and writing files',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => 'Environment Configuration',
        'message' => 'Permanent and basic settings, which are not subject to change',
        'save'    => 'Save .env',
        'success' => 'Your .env file settings have been saved.',
        'errors'  => 'Unable to save the .env file, Please create it manually.',
    ],

    /*
  *
  * Administrator page translations.
  *
  */
    'administrator' => [
        'title'   => 'Creating a user',
        'message' => 'Created by the administrator will be available to all right at the moment',
        'help'    => 'Later you can create using the artisan command',
    ],

    'install' => 'Install',

    /*
     *
     * Final page translations.
     *
     */
    'final'   => [
        'title'   => 'Finished',
        'message' => 'Application has been successfully installed.',
        'exit'    => 'Click here to exit',
    ],
];
