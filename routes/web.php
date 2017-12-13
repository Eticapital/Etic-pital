<?php

Route::get('/', 'HomeController@index')->name('home');
Route::view('/como-funciona', 'como-funciona')->name('como-funciona');

Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/fondo-de-inversion', 'fondo-de-inversion')->name('fondo-de-inversion');
Route::view('/proyecto-dummy', 'proyecto-dummy')->name('proyecto-dummy');

Route::post('/upload', 'UploadController@uploadToTempFolder');
Route::post('/upload/image', 'UploadController@uploadImageToTempFolder');

Route::get('/sectors', 'SectorController@index');
Route::get('/stages', 'ProjectStageController@index');
Route::get('/rewards', 'RewardController@index');

Route::get('/invertir', 'ProjectController@publicList')->name('invertir');

// Proyectos

Route::group(['prefix' => 'projects/{project}'], function () {
    Route::get('/', 'ProjectController@show')->name('projects.show');
    Route::get('/invertir', 'ProjectInvestmentController@create')->name('project.investment.create');
    Route::post('/invertir', 'ProjectInvestmentController@store')->name('project.investment.store');
});


Auth::routes();
