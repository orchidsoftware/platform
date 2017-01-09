<?php

/*
|--------------------------------------------------------------------------
| Tools Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

Route::group(['namespace' => 'Tools', 'prefix' => 'tools'], function () {
    Route::post('files', [
        'as' => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);

    Route::resource('section', 'SectionController', ['names' => [
        'index' => 'dashboard.tools.section',
        'create' => 'dashboard.tools.section.create',
        'edit' => 'dashboard.tools.section.edit',
        'update' => 'dashboard.tools.section.update',
        'store' => 'dashboard.tools.section.store',
        'destroy' => 'dashboard.tools.section.destroy',
    ]]);

    Route::post('files', [
        'as' => 'dashboard.tools.files.upload',
        'uses' => 'FileController@upload',
    ]);
    Route::delete('files/{id}', [
        'as' => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@destroy',
    ]);

    Route::get('files/post/{id}', [
        'as' => 'dashboard.tools.files.destroy',
        'uses' => 'FileController@getFilesPost',
    ]);

    Route::get('database', [
        'as' => 'dashboard.tools.database',
        'uses' => 'DatabaseController@index',
    ]);

    Route::get('/wmenuindex', ['as' => 'wmenuindex', 'uses' => 'MenuController@index']);
    Route::post('/addcustommenu', ['as' => 'addcustommenu', 'uses' => 'WmenuController@addcustommenu']);
    Route::post('/deleteitemmenu', ['as' => 'deleteitemmenu', 'uses' => 'WmenuController@deleteitemmenu']);
    Route::post('/deletemenug', ['as' => 'deletemenug', 'uses' => 'WmenuController@deletemenug']);
    Route::post('/createnewmenu', ['as' => 'createnewmenu', 'uses' => 'WmenuController@createnewmenu']);
    Route::post('/generatemenucontrol', ['as' => 'generatemenucontrol', 'uses' => 'WmenuController@generatemenucontrol']);
    Route::post('/updateitem', ['as' => 'updateitem', 'uses' => 'WmenuController@updateitem']);
});
