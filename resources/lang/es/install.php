<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Instalador de Orchid',
    'next'          => 'Próximo paso',
    'finish'        => 'Instalar',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => 'Bienvenido al Instalador',
        'message' => 'Bienvenido al asistente de configuración.',
        'body'    => 'El proceso básico de instalación de Orchid es el mismo que para la mayoría de las aplicaciones basadas en Laravel. El instalador llama a los comandos Artisan para instalar las migraciones y los componentes relacionados. El programa de instalación coordina el proceso de instalación de principio a fin.',
        'footer'  => 'Intentamos simplificar la instalación del componente del programa en un solo clic. Estamos orgullosos de que este sea un instalador simple y eficaz que nunca.',

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
            'openssl'    => 'OpenSSL PHP Extensión',
            'pdo'        => 'PDO PHP Extensión',
            'mbstring'   => 'Mbstring PHP Extensión',
            'tokenizer'  => 'Tokenizer PHP Extensión',
            'zip'        => 'ZIP Archive PHP Extensión',
            'xml'        => 'XML PHP Extensión',
            'json'       => 'JSON PHP Extensión',
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
        'message' => 'Necesario para leer y escribir archivos',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => 'Configuración del entorno',
        'message' => 'Configuración permanente y básica, que no están sujetas a cambios',
        'save'    => 'Guardar .env',
        'success' => 'Su configuración de archivo .env se ha guardado.',
        'errors'  => 'No se puede guardar el archivo .env, por favor, crear manualmente.',
    ],

    /*
  *
  * Administrator page translations.
  *
  */
    'administrator' => [
        'title'   => 'Creación de un usuario',
        'message' => 'Creado por el administrador estará disponible para todos los derechos en el momento',
        'help'    => 'Más tarde puede crear utilizando el comando artisan',
    ],

    'install' => 'Instalar',

    /*
     *
     * Final page translations.
     *
     */
    'final'   => [
        'title'   => 'Terminado',
        'message' => 'Se ha instalado correctamente la aplicación.',
        'exit'    => 'Haga clic aquí para salir',
    ],
];
