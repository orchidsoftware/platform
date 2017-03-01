<?php


/*
|--------------------------------------------------------------------------
| Install Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

$this->group([
    'middleware' => ['install'],
    'as'         => 'install::',
    'prefix'     => 'dashboard/install',
    'namespace'  => 'Orchid\Foundation\Http\Controllers\Install',
],
    function (\Illuminate\Routing\Router $router) {
        $router->get('/', [
            'as'   => 'welcome',
            'uses' => 'WelcomeController@welcome',
        ]);
        $router->get('/environment', [
            'as'   => 'environment',
            'uses' => 'EnvironmentController@environment',
        ]);
        $router->post('/environment/save', [
            'as'   => 'environmentSave',
            'uses' => 'EnvironmentController@save',
        ]);
        $router->get('/requirements', [
            'as'   => 'requirements',
            'uses' => 'RequirementsController@requirements',
        ]);
        $router->get('/permissions', [
            'as'   => 'permissions',
            'uses' => 'PermissionsController@permissions',
        ]);
        $router->get('/database', [
            'as'   => 'database',
            'uses' => 'DatabaseController@database',
        ]);
        $router->get('/administrator', [
            'as'   => 'administrator',
            'uses' => 'AdministratorController@administrator',
        ]);
        $router->post('/administrator/create', [
            'as'   => 'administratorCreate',
            'uses' => 'AdministratorController@create',
        ]);
        $router->get('/final', [
            'as'   => 'final',
            'uses' => 'FinalController@finish',
        ]);
    });
