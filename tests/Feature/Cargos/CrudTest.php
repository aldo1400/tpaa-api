<?php

namespace Tests\Feature\Cargos;

use App\Area;
use App\Cargo;
use App\Movilidad;
use Tests\TestCase;
use App\Colaborador;
use App\NivelJerarquico;

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
                        'nombre',
                        'supervisor_id',
                        'nivelJerarquico' => [
                            'id',
                            'nivel_nombre',
                            'estado',
                        ],
                        'estado',
                        'area' => [
                            'id',
                            'nombre',
                            'estado'
                        ],
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
                            'nombre' => $cargos[1]->nombre,
                            'supervisor_id' => null,
                            'estado' => $cargos[1]->estado,
                            'nivelJerarquico' => $cargos[1]->nivelJerarquico->only([
                                'id',
                                'nivel_nombre',
                                'estado',
                            ]),
                            'area'=> $cargos[1]->area->only([
                                'id',
                                'nombre',
                                'estado',
                            ]),
                    ],
                ]);
    }

    public function testCrearCargoSinSupervisor()
    {
        $cargo = factory(Cargo::class)->make();
        $nivelJerarquico = factory(NivelJerarquico::class)->create();
        $area = factory(Area::class)->create();

        $url = '/api/cargos';
        $parameters = [
            'nombre' => $cargo->nombre,
            'estado' => $cargo->estado,
            'supervisor_id' => '',
            'nivel_jerarquico_id' => $nivelJerarquico->id,
            'area_id' => $area->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('cargos', [
            'id' => Cargo::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'supervisor_id' => null,
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
            'area_id' => $parameters['area_id'],
            'estado' => $parameters['estado'],
        ]);
    }

     public function testCrearCargoConSupervisor()
    {
        $cargoSupervisor = factory(Cargo::class)->create();
        $cargo = factory(Cargo::class)->make();
        $nivelJerarquico = factory(NivelJerarquico::class)->create();
        $area = factory(Area::class)->create();

        $url = '/api/cargos';
        $parameters = [
            'nombre' => $cargo->nombre,
            'estado' => $cargo->estado,
            'supervisor_id' => $cargoSupervisor->id,
            'nivel_jerarquico_id' => $nivelJerarquico->id,
            'area_id' => $area->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('cargos', [
            'nombre' => $parameters['nombre'],
            'supervisor_id' => $parameters['supervisor_id'],
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
            'area_id' => $parameters['area_id'],
            'estado' => $parameters['estado'],
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
                            'estado'=>1
                        ]);

        $url = '/api/cargos/'.$cargoPadre->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(409)
                    ->assertSeeText('El cargo tiene hijos.');
    }

    public function testEditarCargo()
    {
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class, 1)->make());
                    });

        $supervisor = factory(Cargo::class)->create();

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            // 'nivel_jerarquico' => Cargo::EJECUCION,
            'supervisor_id' => $supervisor->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cargos', [
            'id' => $cargos[0]->id,
            'nombre' => $parameters['nombre'],
            'supervisor_id' => $parameters['supervisor_id'],
        ]);

        $this->assertDatabaseMissing('cargos', [
            'id' => $cargos[0]->id,
            'nombre' => $cargos[0]->nombre,
            'supervisor_id' => $cargos[0]->supervisor_id,
        ]);
    }

    public function testNoSePuedeDesactivarCargoSiTieneCargosHijos()
    {
        
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class, 1)->make());
                    });
        
        $cargoSupervisor=factory(Cargo::class)
                ->create();

        $cargoHijo = factory(Cargo::class)->create([
            'supervisor_id'=>$cargos[0]->id,
            'estado'=>1
        ]);

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'supervisor_id' => $cargoSupervisor->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
// dd($response->decodeResponseJson());
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El cargo tiene hijos.'));

    }

    
    public function testNoSePuedeDesactivarCargoSiTieneMovilidadActiva()
    {
        
        $colaborador=factory(Colaborador::class)->create();
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class, 1)->make());
                    });
        
        $cargoSupervisor=factory(Cargo::class)
                ->create();

        factory(Movilidad::class)->create([
            'cargo_id'=>$cargos[0]->id,
            'estado'=>1,
            'colaborador_id'=>$colaborador->id,
            'fecha_inicio'=>now()->format('Y-m-d')
        ]);

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'supervisor_id' => $cargoSupervisor->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El cargo esta asociada a movilidades.'));

    }
}
