<?php

namespace Tests\Feature\Consultas;

use App\Consulta;
use Tests\TestCase;
use App\Colaborador;
use App\TipoConsulta;

class CrudTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testObtenerUnaConsulta()
    {
        $consultas = factory(Consulta::class, 10)
                        ->create();

        $url = '/api/consultas/'.$consultas[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $consultas[1]->id,
                        'texto' => $consultas[1]->texto,
                        'colaborador' => $consultas[1]->colaborador->only([
                            'id',
                            'estado',
                        ]),
                        'tipoConsulta' => $consultas[1]->tipoConsulta->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                    ],
                ]);
    }

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

    /**
     * A basic test example.
     */
    public function testCrearUnaConsulta()
    {
        $colaborador = factory(Colaborador::class)
                        ->create();

        $tipoConsulta = TipoConsulta::first();

        $url = '/api/colaboradores/'.$colaborador->id.'/consultas';

        $parameters = [
            'tipo_consulta_id' => $tipoConsulta->id,
            'texto' => 'Este es un mensaje de prueba',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('consultas', [
            'id' => Consulta::latest()->first()->id,
            'texto' => $parameters['texto'],
            'colaborador_id' => $colaborador->id,
            'tipo_consulta_id' => $parameters['tipo_consulta_id'],
        ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarCrearUnaConsulta()
    {
        $colaborador = factory(Colaborador::class)
                        ->create();

        $tipoConsulta = TipoConsulta::first();

        $url = '/api/colaboradores/'.$colaborador->id.'/consultas';

        $parameters = [
            'tipo_consulta_id' => '99999',
            'texto' => '',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'tipo_consulta_id',
                'texto',
            ]);
    }

    /**
     * A basic test example.
     */
    public function testEliminarConsulta()
    {
        $consultas = factory(Consulta::class, 5)
                    ->create();

        $url = '/api/consultas/'.$consultas[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('consultas', [
            'id' => $consultas[0]->id,
        ]);

        $response = $this->json('GET', '/api/consultas');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $consultas[1]->id],
                    '1' => ['id' => $consultas[2]->id],
                    '2' => ['id' => $consultas[3]->id],
                    '3' => ['id' => $consultas[4]->id],
                ],
            ]);
    }
}
