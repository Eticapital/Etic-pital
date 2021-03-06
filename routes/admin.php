<?php

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/nav', 'NavController@get');
Route::get('/dashboard', 'DashboardController@getData');

// Mi cuenta
Route::get('account', 'AccountController@index')->name('account.index');
Route::get('account/edit', 'AccountController@edit')->name('account.edit');
Route::put('account', 'AccountController@update')->name('account.update');
Route::get('account/password', 'AccountController@showPasswordForm')->name('account.password-form');
Route::put('account/password', 'AccountController@password')->name('account.password');
Route::get('account/permissions', 'AccountController@permissions')->name('account.permissions');


Route::get('account/projects', 'AccountProjectsController@index')->name('account.projects');
Route::group(['prefix' => 'account/projects/{project}'], function () {
    Route::get('investments', 'AccountProjectsInvestmentsController@index')->name('account.investments');
});

Route::get('investments', 'InvestmentController@index')->name('investments.index');
Route::post('investments', 'InvestmentController@store')->name('investments.store');
Route::post('investments/{investment}', 'InvestmentController@update')->name('investments.update');
Route::get('investments/{investment}', 'InvestmentController@show')->name('investments.show');
Route::post('investments/{investment}/accept', 'InvestmentController@accept')->name('investments.accept');
Route::post('investments/{investment}/reject', 'InvestmentController@reject')->name('investments.reject');
Route::delete('investments/{investment}', 'InvestmentController@destroy')->name('investments.destroy');


// Administrar usuarios
Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
Route::post('users/{user}/status', 'UserController@toggleStatus');

// Proyectos
Route::get('/fondear-mi-proyecto', 'ProjectController@create')
    ->name('fondear-mi-proyecto');
Route::resource('projects', 'ProjectController', ['except' => ['create', 'show']]);
Route::put('projects/{project}/publish', 'ProjectController@publish');
Route::put('projects/{project}/reject', 'ProjectController@reject');
Route::put('projects/{project}/finish', 'ProjectController@finish');

Route::get(
    '/documents/{document}/download/{name?}',
    'ProjectDocumentController@download'
)->name('documents.download');


// Administrar grupos
Route::group(['prefix' => 'roles/{role}'], function () {
    Route::get('permissions', 'RolePermissionController@index')->name('roles.permissions');
    Route::patch('permissions/{permission}', 'RolePermissionController@toggle')->name('roles.permissions.toggle');

    Route::get('users', 'RoleUserController@index')->name('roles.users');
    Route::patch('users/{user}', 'RoleUserController@toggle')->name('roles.users.toggle');
});

Route::resource('roles', 'RoleController');
