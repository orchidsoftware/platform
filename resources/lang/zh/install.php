<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title'         => 'Orchid 安装程序',
    'next'          => '下一步',
    'finish'        => '安装',

    /*
     *
     * Home page translations.
     *
     */
    'welcome'       => [
        'title'   => '欢迎来到安装程序',
        'message' => '欢迎使用安装向导。',
        'body'    => 'Orchid的基本安装过程与大多数基于Laravel的应用程序相同。 安装程序调用Artisan命令来安装迁移和相关组件。 安装程序从头到尾协调安装过程。',
        'footer'  => '我们尝试在一次点击中简化程序组件的安装。 我们很自豪，这是一个比以往任何时候都简单有效的安装程序。',

    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements'  => [
        'title'      => '要求',
        'message'    => '检查安装的PHP模块',
        'extensions' => [
            'openssl'    => 'OpenSSL PHP 延期',
            'pdo'        => 'PDO PHP 延期',
            'mbstring'   => 'Mbstring PHP 延期',
            'tokenizer'  => 'Tokenizer PHP 延期',
            'zip'        => 'ZIP Archive PHP 延期',
            'xml'        => 'XML PHP 延期',
            'json'       => 'JSON PHP 延期',
            'bd_connect' => '连接到数据库',
        ],
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions'   => [
        'title'   => '权限',
        'message' => '读写文件所需',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment'   => [
        'title'   => '环境配置',
        'message' => '永久和基本设置，不会更改',
        'save'    => '保存 .env',
        'success' => '您的.env文件设置已保存。',
        'errors'  => '无法保存.env文件，请手动创建。',
    ],

    /*
  *
  * Administrator page translations.
  *
  */
    'administrator' => [
        'title'   => '创建用户',
        'message' => '此时由管理员创建将可用',
        'help'    => '以后可以使用artisan命令创建',
    ],

    'install' => '安装',

    /*
     *
     * Final page translations.
     *
     */
    'final'   => [
        'title'   => '成品',
        'message' => '应用程序已成功安装。',
        'exit'    => '点击此处退出',
    ],
];
