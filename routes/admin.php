<?php

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/nav', 'NavController@get');

Route::get('account', 'AccountController@index')->name('account.index');
Route::put('account', 'AccountController@update')->name('account.update');
Route::put('account/password', 'AccountController@password')->name('account.password');
