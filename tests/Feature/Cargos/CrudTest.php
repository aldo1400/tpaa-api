<?php

namespace Tests\Feature\Cargos;

use App\Cargo;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerCargos()
    {
        factory(Cargo::class, 10)
                    ->create();

        $url = '/api/cargos';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nivel_jerarquico',
                        'nombre',
                        'supervisor_id',
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnCargo()
    {
        $cargos = factory(Cargo::class, 10)
                        ->create();

        $url = '/api/cargos/'.$cargos[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                            'id' => $cargos[1]->id,
                            'nivel_jerarquico' => $cargos[1]->nivel_jerarquico,
                            'nombre' => $cargos[1]->nombre,
                            'supervisor_id' => null,
                    ],
                ]);
    }

    public function testCrearCargoSinSupervisor()
    {
        $cargo = factory(Cargo::class)->make();
        $url = '/api/cargos';
        $parameters = [
            'nivel_jerarquico' => $cargo->nivel_jerarquico,
            'nombre' => $cargo->nombre,
            'supervisor_id' => '',
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('cargos', [
            'id' => Cargo::latest()->first()->id,
            'nivel_jerarquico' => $parameters['nivel_jerarquico'],
            'nombre' => $parameters['nombre'],
            'supervisor_id' => null,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEliminarCargo()
    {
        $cargos = factory(Cargo::class, 5)
                    ->create();

        $url = '/api/cargos/'.$cargos[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('cargos', [
            'id' => $cargos[0]->id,
        ]);

        $response = $this->json('GET', '/api/cargos');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $cargos[1]->id],
                    '1' => ['id' => $cargos[2]->id],
                    '2' => ['id' => $cargos[3]->id],
                    '3' => ['id' => $cargos[4]->id],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarQueUnCargoConCargosInferioresNoPuedeSerEliminado()
    {
        $cargoPadre = factory(Cargo::class)
                        ->create();

        $cargo = factory(Cargo::class)
                        ->create([
                            'supervisor_id' => $cargoPadre->id,
                        ]);

        $url = '/api/cargos/'.$cargoPadre->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(409)
                    ->assertSeeText('El cargo tiene hijos.');
    }

    public function testEditarCargo()
    {
        $cargos = factory(Cargo::class, 1)
                    ->create([
                            'nivel_jerarquico' => Cargo::ESTRATEGICO_TACTICO,
                    ])
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class, 1)->make());
                    });

        $supervisor = factory(Cargo::class)->create();

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'nivel_jerarquico' => Cargo::EJECUCION,
            'supervisor_id' => $supervisor->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cargos', [
            'id' => $cargos[0]->id,
            'nombre' => $parameters['nombre'],
            'nivel_jerarquico' => $parameters['nivel_jerarquico'],
            'supervisor_id' => $parameters['supervisor_id'],
        ]);

        $this->assertDatabaseMissing('cargos', [
            'id' => $cargos[0]->id,
            'nombre' => $cargos[0]->nombre,
            'nivel_jerarquico' => $cargos[0]->nivel_jerarquico,
            'supervisor_id' => $cargos[0]->supervisor_id,
        ]);
    }
}
