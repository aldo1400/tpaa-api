<?php

namespace Tests\Feature\Consultas;

use App\Consulta;
use Tests\TestCase;
use App\Colaborador;

class CrudTest extends TestCase
{
    public function testObtenerConsultasDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)
                    ->create();

        $consultas = factory(Consulta::class, 3)
                    ->create()
                    ->each(function ($consulta) use ($colaborador) {
                        $consulta->colaborador()->associate($colaborador);
                        $consulta->save();
                    });

        $url = '/api/colaboradores/'.$colaborador->id.'/consultas';

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id' => $consultas[0]->id,
                        'texto' => $consultas[0]->texto,
                        'tipoConsulta' => $consultas[0]->tipoConsulta->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                        'colaborador' => $consultas[0]->colaborador->only([
                            'id',
                            'estado',
                        ]),
                    ],
                    1 => [
                        'id' => $consultas[1]->id,
                        'texto' => $consultas[1]->texto,
                        'tipoConsulta' => $consultas[1]->tipoConsulta->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                        'colaborador' => $consultas[1]->colaborador->only([
                            'id',
                            'estado',
                        ]),
                    ],
                    2 => [
                        'id' => $consultas[2]->id,
                        'texto' => $consultas[2]->texto,
                        'tipoConsulta' => $consultas[2]->tipoConsulta->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                        'colaborador' => $consultas[2]->colaborador->only([
                            'id',
                            'estado',
                        ]),
                    ],
                ],
        ]);
    }
}
