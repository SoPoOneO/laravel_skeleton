<?php

// public
Route::get('/', 'IndexController@index');

// account
Route::get('login', 'AccountController@getLogin');
Route::post('login', 'AccountController@postLogin');
Route::get('logout', 'AccountController@getLogout');
Route::get('account', 'AccountController@getIndex');
Route::post('account', 'AccountController@postIndex');

// private
Route::resource('users', 'UsersController');

