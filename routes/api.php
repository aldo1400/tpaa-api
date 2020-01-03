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
Route::patch('/cargos/{id}', 'Cargos\UpdateProcessController');
Route::post('/cargos', 'Cargos\CreateProcessController');
Route::delete('/cargos/{id}', 'Cargos\DeleteProcessController');

// TipoCarga
Route::get('/tipo-cargas', 'TipoCargas\IndexController');

Route::get('/niveles-educacion', 'NivelesEducacion\IndexController');
Route::get('/estado-civiles', 'EstadoCiviles\IndexController');

// Cursos
Route::get('/cursos', 'Cursos\IndexController');
Route::get('/cursos/{id}', 'Cursos\ShowController');
Route::post('/cursos', 'Cursos\CreateProcessController');
Route::put('/cursos/{id}', 'Cursos\UpdateProcessController');
Route::delete('/cursos/{id}', 'Cursos\DeleteProcessController');

// Colaboradores
Route::get('/colaboradores/validacion-rut', 'Colaboradores\ValidateRutController');
Route::get('/colaboradores/{id}', 'Colaboradores\ShowController');
Route::patch('/colaboradores/{id}', 'Colaboradores\UpdateProcessController');
Route::post('/colaboradores', 'Colaboradores\CreateProcessController');

Route::get('/colaboradores/{id}/cargas-familiares', 'Colaboradores\CargasFamiliares\IndexController');
Route::post('/colaboradores/{id}/cargas-familiares', 'Colaboradores\CargasFamiliares\CreateProcessController');
Route::get('/cargas-familiares/{id}', 'CargasFamiliares\ShowController');
Route::delete('/cargas-familiares/{id}', 'CargasFamiliares\DeleteProcessController');
Route::patch('/cargas-familiares/{id}', 'CargasFamiliares\UpdateProcessController');

Route::post('/cursos-colaborador', 'CursosColaborador\CreateProcessController');

Route::get('/niveles-jerarquico', 'NivelesJerarquico\IndexController');
Route::post('/niveles-jerarquico', 'NivelesJerarquico\CreateProcessController');
Route::get('/niveles-jerarquico/{id}', 'NivelesJerarquico\ShowController');
Route::put('/niveles-jerarquico/{id}', 'NivelesJerarquico\UpdateProcessController');
Route::delete('/niveles-jerarquico/{id}', 'NivelesJerarquico\DeleteProcessController');

Route::get('/tags', 'Tags\IndexController');
Route::post('/tags', 'Tags\CreateProcessController');

Route::get('/tipos-area', 'TipoAreas\IndexController');
Route::post('/tipos-area', 'TipoAreas\CreateProcessController');
Route::patch('/tipos-area/{id}', 'TipoAreas\UpdateProcessController');
