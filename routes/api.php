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

// Departamentos
Route::get('/departamentos', 'Departamentos\IndexController');
Route::post('/departamentos', 'Departamentos\CreateProcessController');
Route::get('/departamentos/{id}', 'Departamentos\ShowController');
Route::patch('/departamentos/{id}', 'Departamentos\UpdateProcessController');
Route::delete('/departamentos/{id}', 'Departamentos\DeleteProcessController');

// Cargos
Route::get('/cargos', 'Cargos\IndexController');
Route::get('/cargos/{id}', 'Cargos\ShowController');
Route::post('/cargos', 'Cargos\CreateProcessController');
Route::delete('/cargos/{id}', 'Cargos\DeleteProcessController');

Route::get('/colaboradores/{id}', 'Colaboradores\ShowController');
Route::post('/colaboradores', 'Colaboradores\CreateProcessController');
