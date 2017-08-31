<?php

/*
|--------------------------------------------------------------------------
| Post API Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['api'],
    'prefix'     => 'api',
    'namespace'  => 'Orchid\Platform\Http\Controllers\Api',
], function ($router) {
});
