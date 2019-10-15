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

Route::group(['middleware' => ['cors', 'jwt']], function(){
    // Cursos GET
    Route::get('/cursos/docente/{id}', 'CursoController@getCursosByDocente');
    Route::get('/cursos/estudiante/{id}', 'EstudianteCursoController@getCursosByEstudiante');

    // Asistencias GET
    Route::get('/asistencias/curso/{curso_id}/{docente_id}', 'AsistenciaController@getAsistenciasByCurso');
    Route::get('/asistencias/estudiante/{curso_id}/{docente_id}', 'AsistenciaController@getAsistenciasByEstudiantes');
    Route::get('/asistencia/{id}', 'AsistenciaController@getAsistencia');
    // Asistencias OPTIONS
    Route::put('/details/update', 'AsistenciaController@updateDetails');
    Route::put('/details/habilitar/{id}', 'AsistenciaController@enabledToggle');
    Route::put('/firmas/update/{id}', 'EstudianteAsistenciaController@updateAsistencias');
    Route::put('/firma/update/{id}', 'EstudianteAsistenciaController@updateAsistencia');
});

Route::group([
    'middleware' => 'cors',
    'prefix' => 'auth'
], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});
