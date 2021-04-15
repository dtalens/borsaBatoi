<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    Route::get('/menu', 'MenuController@index');
});



Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    Route::post('signup', 'AuthController@signup');
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['middleware' => 'auth:api'], function() {

    Route::resource('alumnos', 'Api\AlumnoController', ['except' => ['edit', 'create','destroy']]);
    Route::resource('empresas', 'Api\EmpresaController', ['except' => ['edit', 'create','destroy']]);
    Route::apiResources(
        [   'users' => 'Api\UserController',
            'ofertas' => 'Api\OfertaController',
            'ciclos' => 'Api\CicloController',
        ]);
    Route::put('ofertas/{id}/validar','Api\OfertaController@Valida');
    Route::put('ofertas/{id}/alumno', 'Api\OfertaController@AlumnoInterested');
    Route::put('alumno/{alumno}/ciclo/{id}','Api\AlumnoController@ValidaCiclo');
    Route::get('ofertas-arxiu', 'Api\OfertaController@indexArxiu');
});

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});
