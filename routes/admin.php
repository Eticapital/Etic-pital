<?php

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/nav', 'NavController@get');

// Mi cuenta
Route::get('account', 'AccountController@index')->name('account.index');
Route::put('account', 'AccountController@update')->name('account.update');
Route::put('account/password', 'AccountController@password')->name('account.password');


// Administrar usuarios
Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);

// Administrar grupos
Route::group(['prefix' => 'roles/{role}'], function () {
    Route::get('permissions', 'RolePermissionController@index')->name('roles.permissions');
    Route::patch('permissions/{permission}', 'RolePermissionController@toggle')->name('roles.permissions.toggle');

    Route::get('users', 'RoleUserController@index')->name('roles.users');
    Route::patch('users/{user}', 'RoleUserController@toggle')->name('roles.users.toggle');
});

Route::resource('roles', 'RoleController');
