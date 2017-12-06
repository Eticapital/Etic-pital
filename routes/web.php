<?php

Route::get('/', 'HomeController@index')->name('home');
Route::view('/como-funciona', 'como-funciona')->name('como-funciona');
Route::view('/fondear-mi-proyecto', 'fondear-mi-proyecto')->name('fondear-mi-proyecto');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/fondo-de-inversion', 'fondo-de-inversion')->name('fondo-de-inversion');
Route::view('/proyecto-dummy', 'proyecto-dummy')->name('proyecto-dummy');

Route::post('/upload', 'UploadController@uploadToTempFolder');
Route::post('/upload/image', 'UploadController@uploadImageToTempFolder');

Route::get('/sectors', 'SectorController@index');
Route::get('/stages', 'ProjectStageController@index');
Route::get('/rewards', 'RewardController@index');

Route::get('/invertir', 'ProjectController@index')->name('invertir');
Route::post('/projects', 'ProjectController@store');
Route::get('/projects/{project}', 'ProjectController@show')->name('projects.show');


Auth::routes();
