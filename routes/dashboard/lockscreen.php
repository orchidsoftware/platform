<?php

$this->middleware('locked')->get('/lockscreen',
    '\Rangoo\Lockscreen\Controller\LockscreenController@showUnlockForm')->name('dashboard.lockscreen');
$this->middleware('unlock')->post('/lockscreen', '\Rangoo\Lockscreen\Controller\LockscreenController@lock');
$this->middleware('locked')->delete('/lockscreen', '\Rangoo\Lockscreen\Controller\LockscreenController@unlock');
