<?php

$this->group([
    'middleware' => config('platform.middleware.public'),
    'prefix'     => 'orchid',
    'namespace'  => 'Orchid\Platform\Http\Controllers',
],
    function (\Illuminate\Routing\Router $router) {
        $router->any('{orchid_public}', "PublicProxyController@index")->where('orchid_public', '.+');
    });
