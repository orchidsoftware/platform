<?php

$this->group([
    'middleware' => ['web', 'dashboard'],
    'prefix'     => 'orchid',
    'namespace'  => 'Orchid\Platform\Http\Controllers',
],
    function (\Illuminate\Routing\Router $router) {
        $router->any('{orchid_public}', "PublicProxyController@index")->where('orchid_public', '.+');
    });
