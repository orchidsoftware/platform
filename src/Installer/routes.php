<?php

Route::group(
    [
        'prefix' => 'install',
        'as' => 'install::',
        'namespace' => 'Orchid\Installer\Controllers',
        'middleware' => 'web',
    ],
    function () {
        Route::group(
            ['middleware' => 'canInstall'],
            function () {
                Route::get(
                    '/',
                    [
                        'as' => 'welcome',
                        'uses' => 'WelcomeController@welcome',
                    ]
                );

                Route::get(
                    'environment',
                    [
                        'as' => 'environment',
                        'uses' => 'EnvironmentController@environment',
                    ]
                );

                Route::post(
                    'environment/save',
                    [
                        'as' => 'environmentSave',
                        'uses' => 'EnvironmentController@save',
                    ]
                );

                Route::get(
                    'requirements',
                    [
                        'as' => 'requirements',
                        'uses' => 'RequirementsController@requirements',
                    ]
                );

                Route::get(
                    'permissions',
                    [
                        'as' => 'permissions',
                        'uses' => 'PermissionsController@permissions',
                    ]
                );

                Route::get(
                    'database',
                    [
                        'as' => 'database',
                        'uses' => 'DatabaseController@database',
                    ]
                );
                Route::get(
                    'administrator',
                    [
                        'as' => 'administrator',
                        'uses' => 'AdministratorController@administrator',
                    ]
                );
                Route::post(
                    'administrator/create',
                    [
                        'as' => 'administratorCreate',
                        'uses' => 'AdministratorController@create',
                    ]
                );

                Route::get(
                    'final',
                    [
                        'as' => 'final',
                        'uses' => 'FinalController@finish',
                    ]
                );
            }
        );
    }
);
