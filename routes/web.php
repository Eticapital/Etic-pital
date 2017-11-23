<?php

Route::view('/', 'home')->name('home');
Route::view('/invertir', 'invertir')->name('invertir');
Route::view('/como-funciona', 'como-funciona')->name('como-funciona');
Route::view('/fondear-mi-proyecto', 'fondear-mi-proyecto')->name('fondear-mi-proyecto');
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/fondo-de-inversion', 'fondo-de-inversion')->name('fondo-de-inversion');
Route::view('/proyecto', 'proyecto')->name('proyecto');
Route::view('/proyecto-dummy', 'proyecto-dummy')->name('proyecto-dummy');

Route::post('/upload', 'UploadController@uploadToTempFolder');

Route::get('/sectors', 'SectorController@index');
Route::get('/stages', 'ProjectStageController@index');

Route::post('/projects', 'ProjectController@store');


Auth::routes();
