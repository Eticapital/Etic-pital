<?php

// Rutas para integrar sitio de eticapital entregado por tercero con plataforma
Route::view('/', 'corporativo')->name('corporativo');
Route::view('/index.html', 'corporativo')->name('corporativo');
Route::view('/fondos-de-inversión.html', 'corporativo-fondo-de-inversion');
Route::view('/contacto-inversionista.html', 'corporativo-contacto-inversionista');

Route::group(['prefix' => 'plataforma'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::view('/como-funciona', 'como-funciona')->name('como-funciona');

    Route::view('/nosotros', 'nosotros')->name('nosotros');
    Route::view('/fondo-de-inversion', 'fondo-de-inversion')->name('fondo-de-inversion');

    Route::view('/terminos-y-condiciones', 'terminos-y-condiciones')->name('terminos-y-condiciones');
    Route::view('/aviso-de-privacidad', 'aviso-de-privacidad')->name('aviso-de-privacidad');

    // Proyectos
    Route::group(['prefix' => 'projects/{project}'], function () {
        Route::get('/', 'ProjectController@show')->name('projects.show');
        Route::get('/invertir', 'ProjectInvestmentController@create')->name('project.investment.create');
        Route::post('/invertir', 'ProjectInvestmentController@store')->name('project.investment.store');
    });

    Route::get('/invertir', 'ProjectController@publicList')->name('invertir');
});

Route::get('account/{email}/activate/{token}', 'AccountController@showActivationForm')->name('account.activate');
Route::put('account/{email}/activate/{token}', 'AccountController@activate');

// Proyectos url fija
Route::group(['prefix' => 'projects/{project}'], function () {
    Route::get('/', 'ProjectController@show');
    Route::get('/invertir', 'ProjectInvestmentController@create');
    Route::post('/invertir', 'ProjectInvestmentController@store');
});

Route::post('/upload', 'UploadController@uploadToTempFolder');
Route::post('/upload/image', 'UploadController@uploadImageToTempFolder');
Route::post('/fondo-de-inversion', 'FondoDeInversionController@submitForm');

Route::get('/sectors', 'SectorController@index');
Route::get('/stages', 'ProjectStageController@index');
Route::get('/rewards', 'RewardController@index');


Auth::routes();
