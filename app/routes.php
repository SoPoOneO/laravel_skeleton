<?php


Route::get('/', 'IndexController@index');

Route::resource('users', 'UsersController');

Route::controller('account', 'AccountController');
