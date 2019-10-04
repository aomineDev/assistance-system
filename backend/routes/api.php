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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function(){
    Route::get('/user/{id}', 'UserController@index');
    Route::get('/estudiante/{id}', 'EstudianteController@index');
    Route::get('/curso/{id}', 'CursoController@index');
    Route::get('/userCursos/{id}', 'UserCursoController@index');
    Route::get('/estudianteCursos/{id}', 'EstudianteCursoController@index');
    // Asistencias
    Route::get('/asistencias/{id}', 'AsistenciaController@getAsistenciasByCurso');
    Route::get('/asistencia/{id}', 'AsistenciaController@getAsistencia');
});
