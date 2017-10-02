<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Instalador de Orchid',
    'next'          => 'Próximo paso',
    'finish'        => 'Finalizar',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => 'Instalación',
        'message' => 'Bienvenido al asistente de configuración.',
        'body'    => 'El proceso básico de instalación de Orchid es el mismo que para la mayoría de las aplicaciones basadas en Laravel. El instalador llama a los comandos Artisan para instalar las migraciones y los componentes relacionados. El programa de instalación coordina el proceso de instalación de principio a fin.',
        'footer'  => 'Intentamos simplificar la instalación a un solo clic. Nos enorgullece que la instalación sea más simple y eficaz que nunca.',

    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements'  => [
        'title'      => 'Requisitos',
        'message'    => 'Comprobación de los módulos PHP instalados',
        'extensions' => [
            'openssl'    => 'Extensión OpenSSL PHP',
            'pdo'        => 'Extensión PDO PHP',
            'mbstring'   => 'Extensión Mbstring PHP',
            'tokenizer'  => 'Extensión Tokenizer PHP',
            'zip'        => 'Extensión ZIP Archive PHP',
            'xml'        => 'Extensión XML PHP',
            'json'       => 'Extensión JSON PHP',
            'bd_connect' => 'Conexión a la base de datos',
        ],
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions'   => [
        'title'   => 'Permisos',
        'message' => 'Necesarios para leer y escribir archivos',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => 'Configuración del entorno',
        'message' => 'Configuración permanente y básica, no están sujetas a cambios',
        'save'    => 'Guardar .env',
        'success' => 'La configuración del archivo .env se ha guardado.',
        'errors'  => 'No se pudó guardar el archivo .env, favor de crearlo manualmente.',
    ],

    /*
  *
  * Administrator page translations.
  *
  */
    'administrator' => [
        'title'   => 'Creación de un usuario',
        'message' => 'Creado por el administrador, tendrá todos los derechos disponibles hasta el momento',
        'help'    => 'Más tarde puede crear un administrador utilizando el comando artisan',
    ],

    'install' => 'Instalar',

    /*
     *
     * Final page translations.
     *
     */
    'final'   => [
        'title'   => 'Finalizado',
        'message' => 'La aplicación se ha instalado correctamente',
        'exit'    => 'Haga clic aquí para salir',
    ],
];
