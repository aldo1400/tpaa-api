<?php

namespace Tests\Feature\CargasFamiliares;

use App\TipoCarga;
use Tests\TestCase;
use App\Colaborador;
use App\CargaFamiliar;

class CrudTest extends TestCase
{
    public function testObtenerCargasFamiliaresDeUnColaborador()
    {
        $colaboradores = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) {
                        $colaborador->cargasFamiliares()->saveMany(factory(CargaFamiliar::class, 2)->make());
                    });

        $url = '/api/colaboradores/'.$colaboradores[0]->id.'/cargas-familiares';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    '0' => [
                        'id' => $colaboradores[0]->cargasFamiliares[0]->id,
                        'rut' => $colaboradores[0]->cargasFamiliares[0]->rut,
                        'nombres' => $colaboradores[0]->cargasFamiliares[0]->nombres,
                        'apellidos' => $colaboradores[0]->cargasFamiliares[0]->apellidos,
                        'fecha_nacimiento' => $colaboradores[0]->cargasFamiliares[0]->fecha_nacimiento->format('d-m-Y'),
                        'estado' => $colaboradores[0]->cargasFamiliares[0]->estado,
                    ],
                    '1' => [
                        'id' => $colaboradores[0]->cargasFamiliares[1]->id,
                        'rut' => $colaboradores[0]->cargasFamiliares[1]->rut,
                        'nombres' => $colaboradores[0]->cargasFamiliares[1]->nombres,
                        'apellidos' => $colaboradores[0]->cargasFamiliares[1]->apellidos,
                        'fecha_nacimiento' => $colaboradores[0]->cargasFamiliares[1]->fecha_nacimiento->format('d-m-Y'),
                        'estado' => $colaboradores[0]->cargasFamiliares[1]->estado,
                    ],
                ],
            ]);
    }

    public function testObtenerUnaCargaFamiliar()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargaFamiliar = factory(CargaFamiliar::class)->create([
            'colaborador_id' => $colaborador->id,
        ]);

        $url = '/api/cargas-familiares/'.$cargaFamiliar->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $cargaFamiliar->id,
                        'rut' => $cargaFamiliar->rut,
                        'nombres' => $cargaFamiliar->nombres,
                        'apellidos' => $cargaFamiliar->apellidos,
                        'fecha_nacimiento' => $cargaFamiliar->fecha_nacimiento->format('d-m-Y'),
                        'estado' => $cargaFamiliar->estado,
                ],
            ]);
    }

    public function testCrearCargaFamiliar()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargaTipo = factory(TipoCarga::class)->create();
        $cargaFamiliar = factory(CargaFamiliar::class)->make();

        $url = '/api/colaboradores/'.$colaborador->id.'/cargas-familiares';

        $parameters = [
            'rut' => $cargaFamiliar->rut,
            'nombres' => $cargaFamiliar->nombres,
            'apellidos' => $cargaFamiliar->apellidos,
            'fecha_nacimiento' => $cargaFamiliar->fecha_nacimiento->format('Y-m-d'),
            'estado' => $cargaFamiliar->estado,
            'tipo_carga_id' => $cargaTipo->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('cargas_familiares', [
            'id' => CargaFamiliar::latest()->first()->id,
            'rut' => $parameters['rut'],
            'nombres' => $parameters['nombres'],
            'apellidos' => $parameters['apellidos'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'estado' => $parameters['estado'],
            'tipo_carga_id' => $parameters['tipo_carga_id'],
            'colaborador_id' => $colaborador->id,
        ]);
    }
}
