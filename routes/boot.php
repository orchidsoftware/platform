<?php


$this->get('/', [
    'as'   => 'platform.boot.index',
    'uses' => 'BootController@index',
]);
