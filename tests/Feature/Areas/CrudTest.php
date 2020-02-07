<?php

namespace Tests\Feature\Areas;

use App\Area;
use App\Cargo;
use App\TipoArea;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerTodasAreas()
    {
        factory(Area::class, 10)
                    ->create([
                        'tipo_area_id' => 1,
                    ]);

        $url = '/api/areas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'estado',
                        'tipoArea' => [
                            'id',
                            'tipo_nombre',
                            'nivel',
                            'estado',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerAreasActivas()
    {
        factory(Area::class, 5)
                    ->create([
                        'tipo_area_id' => 1,
                        'estado'=>1
                    ]);

        factory(Area::class, 3)
                    ->create([
                        'tipo_area_id' => 1,
                        'estado'=>0
                    ]);

        $url = '/api/areas?estado=true';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'estado',
                        'tipoArea' => [
                            'id',
                            'tipo_nombre',
                            'nivel',
                            'estado',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerAreasInactivas()
    {
        factory(Area::class, 5)
                    ->create([
                        'tipo_area_id' => 1,
                        'estado'=>1
                    ]);

        factory(Area::class, 3)
                    ->create([
                        'tipo_area_id' => 1,
                        'estado'=>0
                    ]);

        $url = '/api/areas?estado=false';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'estado',
                        'tipoArea' => [
                            'id',
                            'tipo_nombre',
                            'nivel',
                            'estado',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerUnaArea()
    {
        $areas = factory(Area::class, 10)
                    ->create([
                        'tipo_area_id' => 1,
                    ]);

        $url = '/api/areas/'.$areas[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $areas[1]->id,
                        'nombre' => $areas[1]->nombre,
                        'estado' => $areas[1]->estado,
                        'padre_id' => '',
                        'tipoArea' => $areas[1]->tipoArea->only([
                            'id',
                            'tipo_nombre',
                            'nivel',
                            'estado',
                        ]),
                ],
            ]);
    }

    public function testCrearAreaSinPadre()
    {
        $area = factory(Area::class)->make();

        $tipoArea = TipoArea::first();
        $url = '/api/areas';

        $parameters = [
            'nombre' => $area->nombre,
            'padre_id' => '',
            'tipo_area_id' => $tipoArea->id,
            'estado' => 1,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('areas', [
            'id' => Area::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'estado' => 1,
            'padre_id' => null,
            'tipo_area_id' => $parameters['tipo_area_id'],
        ]);
    }

    public function testValidarCrearAreaSinPadre()
    {
        $area = factory(Area::class)->make();
        $url = '/api/areas';
        $parameters = [
            'estado' => '',
            'nombre' => '',
            'padre_id' => '',
            'tipo_area_id' => '',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'nombre',
                'estado',
                'tipo_area_id',
            ]);

        $parameters = [
                'nombre' => $area->nombre,
                'padre_id' => '99999',
                'tipo_area_id' => '99999',
            ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'padre_id',
                    'tipo_area_id',
                    'estado',
                ]);
    }

    public function testCrearAreaConPadre()
    {
        $areaPadre = factory(Area::class)->create();
        $area = factory(Area::class)->make();
        $tipoArea = TipoArea::first();
        $url = '/api/areas';

        $parameters = [
            'tipo' => $area->tipo,
            'nombre' => $area->nombre,
            'estado' => $area->estado,
            'padre_id' => $areaPadre->id,
            'tipo_area_id' => $tipoArea->id,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('areas', [
            'nombre' => $parameters['nombre'],
            'estado' => $parameters['estado'],
            'padre_id' => $parameters['padre_id'],
            'tipo_area_id' => $parameters['tipo_area_id'],
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEliminarArea()
    {
        $areas = factory(Area::class, 5)
                    ->create();

        $url = '/api/areas/'.$areas[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('areas', [
            'id' => $areas[0]->id,
        ]);

        $response = $this->json('GET', '/api/areas');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $areas[1]->id],
                    '1' => ['id' => $areas[2]->id],
                    '2' => ['id' => $areas[3]->id],
                    '3' => ['id' => $areas[4]->id],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarQueUnAreaConAreasInferioresNoPuedeSerEliminado()
    {
        $areaPadre = factory(Area::class)
                        ->create();

        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areaPadre->id,
                            'estado' => 1,
                        ]);

        $url = '/api/areas/'.$areaPadre->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(409)
                    ->assertSeeText('El area tiene hijos.');
    }

    public function testEditarAreaConEstadoActivo()
    {
        $areas = factory(Area::class, 2)->create();
        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areas[0]->id,
                            'tipo_area_id' => 4,
                        ]);

        $tipoArea = TipoArea::where('tipo_nombre', 'Subgerencia')->first();

        $url = "/api/areas/{$area->id}";

        $parameters = [
            'nombre' => 'Area de administración de recursos humanos',
            'padre_id' => $areas[1]->id,
            'estado' => 1,
            'tipo_area_id' => $tipoArea->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('areas', [
            'id' => $area->id,
            'nombre' => $parameters['nombre'],
            'padre_id' => $parameters['padre_id'],
            'estado' => $parameters['estado'],
            'tipo_area_id' => $parameters['tipo_area_id'],
        ]);

        $this->assertDatabaseMissing('areas', [
            'id' => $area->id,
            'nombre' => $area->nombre,
            'padre_id' => $area->padre_id,
            'estado' => $area->estado,
            'tipo_area_id' => $area->tipo_area_id,
        ]);
    }

    public function testEditarAreaSinHijosAEstadoInactivo()
    {
        $areas = factory(Area::class, 2)->create();
        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areas[0]->id,
                            'tipo_area_id' => 4,
                        ]);

        $tipoArea = TipoArea::where('tipo_nombre', 'Subgerencia')->first();

        $url = "/api/areas/{$area->id}";

        $parameters = [
            'nombre' => 'Area de administración de recursos humanos',
            'padre_id' => $areas[1]->id,
            'estado' => 0,
            'tipo_area_id' => $tipoArea->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(200);

        $this->assertDatabaseHas('areas', [
            'id' => $area->id,
            'nombre' => $parameters['nombre'],
            'padre_id' => $parameters['padre_id'],
            'estado' => $parameters['estado'],
            'tipo_area_id' => $parameters['tipo_area_id'],
        ]);

        $this->assertDatabaseMissing('areas', [
            'id' => $area->id,
            'nombre' => $area->nombre,
            'padre_id' => $area->padre_id,
            'estado' => $area->estado,
            'tipo_area_id' => $area->tipo_area_id,
        ]);
    }

    public function testEditarAreaConHijos()
    {
        $areas = factory(Area::class, 2)->create();
        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areas[0]->id,
                            'tipo_area_id' => 4,
                        ]);

        $areaHijo = factory(Area::class)
                        ->create([
                            'padre_id' => $area->id,
                            'estado' => 1,
                            'tipo_area_id' => 5,
                        ]);

        $tipoArea = TipoArea::where('tipo_nombre', 'Subgerencia')->first();

        $url = "/api/areas/{$area->id}";

        $parameters = [
            'nombre' => 'Area de administración de recursos humanos',
            'padre_id' => $areas[1]->id,
            'estado' => $area->estado,
            'tipo_area_id' => $area->tipo_area_id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(200);

        $this->assertDatabaseHas('areas', [
            'id' => $area->id,
            'nombre' => $parameters['nombre'],
            'padre_id' => $parameters['padre_id'],
            'estado' => $parameters['estado'],
            'tipo_area_id' => $parameters['tipo_area_id'],
        ]);

        $this->assertDatabaseMissing('areas', [
            'id' => $area->id,
            'nombre' => $area->nombre,
            'padre_id' => $area->padre_id,
            'estado' => $area->estado,
            'tipo_area_id' => $area->tipo_area_id,
        ]);
    }

    public function testNoSePuedeDesactivarUnAreaSiEsPadreDeOtraArea()
    {
        $areas = factory(Area::class, 2)->create();

        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areas[0]->id,
                            'tipo_area_id' => 4,
                        ]);

        $areaHijo = factory(Area::class)
                        ->create([
                            'padre_id' => $area->id,
                            'estado' => 1,
                            'tipo_area_id' => 5,
                        ]);

        $tipoArea = TipoArea::where('tipo_nombre', 'Subgerencia')->first();

        $url = "/api/areas/{$area->id}";

        $parameters = [
            'nombre' => 'Area de administración de recursos humanos',
            'padre_id' => $areas[1]->id,
            'estado' => 0,
            'tipo_area_id' => $tipoArea->id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El area tiene hijos.'));
    }

    public function testNoSePuedeDesactivarUnAreaSiEstaAsociadaAUnCargo()
    {
        $areas = factory(Area::class, 2)->create();

        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areas[0]->id,
                            'estado'=>1
                        ]);

        factory(Cargo::class)->create([
            'area_id' => $area->id,
        ]);

        $url = "/api/areas/{$area->id}";

        $parameters = [
            'nombre' => 'Area de administración de recursos humanos',
            'padre_id' => $areas[1]->id,
            'estado' => 0,
            'tipo_area_id'=>$area->tipo_area_id
        ];

        $response = $this->json('PATCH', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El area esta asociada a cargos.'));
    }

    public function testObtenerTodosLosPadresDeArea()
    {
        $areaAbuelo = factory(Area::class)
                    ->create();

        $areaPadre = factory(Area::class)
                    ->create([
                        'padre_id' => $areaAbuelo->id,
                    ]);

        $area = factory(Area::class)
                        ->create([
                            'padre_id' => $areaPadre->id,
                        ]);

        $url = "/api/areas/{$area->id}/relacionados";

        $response = $this->json('GET', $url);
        // dd($response->decodeResponseJson());
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'padre_id',
                        'estado',
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosPadresDeUnAreaEnCasoNoHayaPadres()
    {
        $area = factory(Area::class)
                        ->create();

        $url = "/api/areas/{$area->id}/relacionados";

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }
}
