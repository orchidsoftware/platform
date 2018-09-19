<?php

/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
|
| Base route
|
*/

// Index and default...
$this->get('/', function (){
    return redirect()->route(config('platform.index'));
})->name('platform.index');

$this->fallback(function () {
    return view('platform::errors.404');
});
