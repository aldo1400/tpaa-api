<?php

namespace Tests\Feature\CargasFamiliares;

use App\TipoCarga;
use Tests\TestCase;
use App\Colaborador;
use App\CargaFamiliar;

class CrudTest extends TestCase
{
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
