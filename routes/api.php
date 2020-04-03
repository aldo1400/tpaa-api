<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ColaboradorResource;
use App\Http\Resources\AdministradorResource;

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

// Route::group(['middleware' => 'guest:api'], function () {
    Route::post(
        'login',
        'Auth\LoginController@login'
    );
    Route::post('register', 'Auth\RegisterController@register');
// });

Route::group(['middleware' => ['auth:colaboradores']], function () {
    Route::get('/colaborador', function (Request $request) {
        return new ColaboradorResource(Auth::guard('colaboradores')->user(), 'tags');
    });
});

Route::group(['middleware' => ['auth:colaboradores,api']], function () {
    Route::post(
        '/logout',
        'Auth\LoginController@logout'
    );
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/administrador', function (Request $request) {
        return new AdministradorResource(Auth::guard('api')->user());
    });

    Route::post('/administradores', 'Administradores\CreateProcessController');
    Route::get('/administradores', 'Administradores\IndexController');
    Route::get('/administradores/{id}', 'Administradores\ShowController');
    Route::put('/administradores', 'Administradores\UpdateProfileController');
    Route::put('/administradores/{id}', 'Administradores\UpdateProcessController');
});

Route::get('/notificaciones', 'Notificaciones\IndexController');
Route::get('/colaboradores/{id}/notificaciones', 'Colaboradores\Notificaciones\IndexController');

Route::get('/colaboradores/{id}/cursos-disponibles', 'Colaboradores\Cursos\GetAvailableController');
Route::get('/cursos/{id}/colaboradores-disponibles', 'Cursos\Colaboradores\GetAvailableController');

Route::get('/colaboradores/import-data', 'Colaboradores\ImportDataController');

// Areas
Route::get('/areas', 'Areas\IndexController');
Route::get('/areas/import', 'Areas\ImportDataController');
Route::get('/areas/validar-nombre', 'Areas\ValidateUniqueController');
Route::get('/areas/{id}/validar-nombre', 'Areas\ValidateUniqueUpdateController');
Route::post('/areas', 'Areas\CreateProcessController');
Route::get('/areas/{id}', 'Areas\ShowController');
Route::get('/areas/{id}/relacionados', 'Areas\GetRelatedController');
Route::patch('/areas/{id}', 'Areas\UpdateProcessController');
Route::delete('/areas/{id}', 'Areas\DeleteProcessController');

// Cargos
Route::get('/cargos', 'Cargos\IndexController');
Route::get('/cargos/import', 'Cargos\ImportDataController');
Route::get('/cargos/validar-nombre', 'Cargos\ValidateUniqueController');
Route::get('/cargos/{id}/validar-nombre', 'Cargos\ValidateUniqueUpdateController');

Route::get('/cargos/{id}', 'Cargos\ShowController');
Route::get('/cargos/{id}/relacionados', 'Cargos\GetRelatedController');
Route::get('/cargos/{id}/supervisores', 'Cargos\GetHierarchicalController');
Route::patch('/cargos/{id}', 'Cargos\UpdateProcessController');
Route::post('/cargos', 'Cargos\CreateProcessController');
Route::delete('/cargos/{id}', 'Cargos\DeleteProcessController');

// TipoCarga

// Cursos
Route::get('/cursos', 'Cursos\IndexController');
Route::get('/cursos/import', 'Cursos\ImportDataController');
Route::get('/cursos/{id}', 'Cursos\ShowController');
Route::post('/cursos', 'Cursos\CreateProcessController');
Route::put('/cursos/{id}', 'Cursos\UpdateProcessController');
Route::delete('/cursos/{id}', 'Cursos\DeleteProcessController');

// Colaboradores
Route::get('/colaboradores', 'Colaboradores\IndexController');
Route::get('/colaboradores/tags/import', 'Colaboradores\Tags\ImportDataController');
Route::get('/colaboradores/validacion-rut', 'Colaboradores\ValidateRutController');
Route::get('/colaboradores/{id}', 'Colaboradores\ShowController');
Route::patch('/colaboradores/{id}', 'Colaboradores\UpdateProcessController');
Route::post('/colaboradores', 'Colaboradores\CreateProcessController');

Route::delete('/colaboradores/{id}/imagen', 'Colaboradores\DeleteImageController');

Route::put('/movilidades/{id}', 'Colaboradores\Movilidades\UpdateProcessController');
Route::get('/movilidades/import', 'Movilidades\ImportDataController');
Route::get('/movilidades/{id}', 'Movilidades\ShowController');
Route::get('/colaboradores/{id}/movilidades', 'Colaboradores\Movilidades\IndexController');
Route::post('/colaboradores/{id}/movilidades', 'Colaboradores\Movilidades\CreateProcessController');
Route::post('/colaboradores/{id}/movilidades/historicos', 'Colaboradores\Movilidades\CreateHistoricController');
Route::delete('/movilidades/{id}', 'Colaboradores\Movilidades\DeleteProcessController');

Route::get('/colaboradores/{id}/capacitaciones', 'Colaboradores\Capacitaciones\IndexController');
Route::post('/colaboradores/{id}/capacitaciones', 'Colaboradores\Capacitaciones\CreateProcessController');

Route::get('/cargas-familiares/import', 'CargasFamiliares\ImportDataController');
Route::get('/colaboradores/{id}/cargas-familiares', 'Colaboradores\CargasFamiliares\IndexController');
Route::post('/colaboradores/{id}/cargas-familiares', 'Colaboradores\CargasFamiliares\CreateProcessController');
Route::get('/cargas-familiares/{id}', 'CargasFamiliares\ShowController');
Route::delete('/cargas-familiares/{id}', 'CargasFamiliares\DeleteProcessController');
Route::patch('/cargas-familiares/{id}', 'CargasFamiliares\UpdateProcessController');

Route::get('/vista-pdf', 'TestingController');
Route::get('/colaboradores-hijos/{rut}', 'Colaboradores\Testing');

Route::post('/cursos/{id}/capacitaciones', 'Capacitaciones\CreateProcessController');
Route::get('/capacitaciones/{id}', 'Capacitaciones\ShowController');
Route::put('/capacitaciones/{id}', 'Capacitaciones\UpdateProcessController');
Route::delete('/capacitaciones/{id}', 'Capacitaciones\DeleteProcessController');

Route::get('/niveles-jerarquico', 'NivelesJerarquico\IndexController');
Route::post('/niveles-jerarquico', 'NivelesJerarquico\CreateProcessController');
Route::get('/niveles-jerarquico/{id}', 'NivelesJerarquico\ShowController');
Route::put('/niveles-jerarquico/{id}', 'NivelesJerarquico\UpdateProcessController');
Route::delete('/niveles-jerarquico/{id}', 'NivelesJerarquico\DeleteProcessController');

Route::get('/colaboradores/{id}/tags', 'Colaboradores\Tags\IndexController');
Route::get('/colaboradores/{id}/comentarios', 'Colaboradores\Comentarios\IndexController');
// Route::get('/colaboradores/{id}/comentarios', 'Colaboradores\Tags\IndexController');

Route::get('/colaboradores/{id}/consultas', 'Colaboradores\Consultas\IndexController');
Route::post('/colaboradores/{id}/consultas', 'Colaboradores\Consultas\CreateProcessController');
Route::get('/consultas/{id}', 'Consultas\ShowController');
Route::patch('/consultas/{id}', 'Consultas\UpdateProcessController');
Route::patch('/consultas/{id}/estado', 'Consultas\UpdateStatusReadController');
Route::delete('/consultas/{id}', 'Consultas\DeleteProcessController');
Route::post('/consultas', 'Colaboradores\Consultas\CreateProcessController');
Route::get('/consultas', 'Consultas\IndexController');

Route::get('/tags', 'Tags\IndexController');
Route::get('/tags/import', 'Tags\ImportDataController');
Route::get('/tags/{id}', 'Tags\ShowController');
Route::put('/tags/{id}', 'Tags\UpdateProcessController');
Route::delete('/tags/{id}', 'Tags\DeleteProcessController');
Route::post('/tags', 'Tags\CreateProcessController');

Route::get('/tipos-area', 'TipoAreas\IndexController');
Route::get('/tipos-area/{id}', 'TipoAreas\ShowController');
Route::post('/tipos-area', 'TipoAreas\CreateProcessController');
Route::patch('/tipos-area/{id}', 'TipoAreas\UpdateProcessController');
Route::delete('/tipos-area/{id}', 'TipoAreas\DeleteProcessController');

Route::post('/comentarios', 'Comentarios\CreateProcessController');
Route::get('/comentarios', 'Comentarios\IndexController');
Route::get('/comentarios/{id}', 'Comentarios\ShowController');
Route::put('/comentarios/{id}', 'Comentarios\UpdateProcessController');

Route::get('/tipo-comentarios', 'TipoComentarios\IndexController');
Route::get('/tipo-cursos', 'TipoCursos\IndexController');
Route::get('/estado-civiles', 'EstadoCiviles\IndexController');
Route::get('/niveles-educacion', 'NivelesEducacion\IndexController');
Route::get('/tipo-movilidades', 'TipoMovilidades\IndexController');
Route::get('/tipo-cargas', 'TipoCargas\IndexController');
Route::get('/tipo-consultas', 'TipoConsultas\IndexController');

Route::get('/encuesta-plantillas', 'EncuestaPlantillas\IndexController');
Route::get('/encuesta-plantillas/{id}/preguntas', 'EncuestaPlantillas\Preguntas\IndexController');

Route::get('/encuestas', 'Encuestas\IndexController');
Route::post('/encuestas', 'Encuestas\CreateProcessController');
Route::get('/encuestas/{id}', 'Encuestas\ShowController');
Route::patch('/encuestas/{id}', 'Encuestas\UpdateProcessController');
Route::post('/encuestas/{id}/colaboradores', 'Encuestas\Colaboradores\CreateProcessController');

Route::get('/periodos', 'Periodos\IndexController');
Route::post('/periodos', 'Periodos\CreateProcessController');
Route::get('/periodos/{id}', 'Periodos\ShowController');
Route::get('/periodos/{id}/encuestas', 'Periodos\Encuestas\IndexController');
Route::put('/periodos/{id}', 'Periodos\UpdateProcessController');
Route::delete('/periodos/{id}', 'Periodos\DeleteProcessController');
