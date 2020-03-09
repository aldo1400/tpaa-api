<?php

namespace Tests\Feature\Cargos;

use App\Area;
use App\Cargo;
use App\Movilidad;
use Tests\TestCase;
use App\Colaborador;
use App\NivelJerarquico;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
                        'organigrama_url',
                        'descriptor_url',
                        'estado',
                        'area' => [
                            'id',
                            'nombre',
                            'estado',
                        ],
                        'nombre_fantasia',
                    ],
                ],
            ]);
    }

    public function testObtenerCargosActivos()
    {
        factory(Cargo::class, 10)
                    ->create([
                        'estado' => 0,
                    ]);

        factory(Cargo::class, 2)
                    ->create([
                        'estado' => 1,
                    ]);

        $url = '/api/cargos?estado=true';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
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
                        'organigrama_url',
                        'descriptor_url',
                        'estado',
                        'area' => [
                            'id',
                            'nombre',
                            'estado',
                        ],
                        'nombre_fantasia',
                    ],
                ],
            ]);
    }

    public function testObtenerCargosInactivos()
    {
        factory(Cargo::class, 7)
                    ->create([
                        'estado' => 0,
                    ]);

        factory(Cargo::class, 2)
                    ->create([
                        'estado' => 1,
                    ]);

        $url = '/api/cargos?estado=false';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(7, 'data')
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
                        'organigrama_url',
                        'descriptor_url',
                        'estado',
                        'area' => [
                            'id',
                            'nombre',
                            'estado',
                        ],
                        'nombre_fantasia',
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
                            'supervisor_id' => '',
                            'estado' => $cargos[1]->estado,
                            'nivelJerarquico' => $cargos[1]->nivelJerarquico->only([
                                'id',
                                'nivel_nombre',
                                'estado',
                            ]),
                            'area' => $cargos[1]->area->only([
                                'id',
                                'nombre',
                                'estado',
                            ]),
                            'organigrama_url' => '',
                            'descriptor_url' => '',
                            'nombre_fantasia' => $cargos[1]->nombre_fantasia,
                    ],
                ]);
    }

    public function testValidarNombreDeCargpNuevo()
    {
        $nombre = 'Cargo importante';
        $cargo = factory(Cargo::class)
                    ->create([
                        'nombre' => $nombre,
                    ]);

        $url = '/api/cargos/validar-nombre?nombre='.$nombre;
        $response = $this->json('GET', $url);

        $response->assertStatus(422);
    }

    public function testValidarNombreDeCargoNuevoAlActualizar()
    {
        $nombre = 'Cargo importante';
        $cargo = factory(Cargo::class)
                    ->create([
                        'nombre' => $nombre,
                        'estado' => 1,
                    ]);

        $url = '/api/cargos/'.$cargo->id.'/validar-nombre?nombre='.$cargo->nombre;
        $response = $this->json('GET', $url);

        $response->assertStatus(200);
    }

    public function testNoDebeDejarQueUnNombreDeCargoNuevaSeaIgualAOtro()
    {
        $nombre = 'Cargo importante';
        $cargo = factory(Cargo::class)
                    ->create([
                        'nombre' => 'Cargo secundario',
                        'estado' => 1,
                    ]);

        factory(Cargo::class)
                    ->create([
                        'nombre' => 'Cargo importante',
                        'estado' => 1,
                    ]);

        $url = '/api/cargos/'.$cargo->id.'/validar-nombre?nombre='.$nombre;
        $response = $this->json('GET', $url);

        $response->assertStatus(422);
    }

    public function testCrearCargoSinSupervisor()
    {
        $cargo = factory(Cargo::class)->make();
        $nivelJerarquico = factory(NivelJerarquico::class)->create();
        $area = factory(Area::class)->create();

        Storage::fake('local');

        $descriptor = UploadedFile::fake()->create('descriptor.pdf');
        $organigrama = UploadedFile::fake()->create('organigrama.pdf');

        $url = '/api/cargos';
        $parameters = [
            'nombre' => $cargo->nombre,
            'estado' => $cargo->estado,
            'supervisor_id' => '',
            'nivel_jerarquico_id' => $nivelJerarquico->id,
            'area_id' => $area->id,
            'descriptor' => $descriptor,
            'organigrama' => $organigrama,
            'nombre_fantasia' => $cargo->nombre_fantasia,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $cargoCreado = Cargo::latest()->first();
        $descriptorUrl = 'public/cargos/'.$cargoCreado->id.'_'.$cargoCreado->nombre.'_descriptor'.'.'.$descriptor->extension();
        $organigramaUrl = 'public/cargos/'.$cargoCreado->id.'_'.$cargoCreado->nombre.'_organigrama'.'.'.$organigrama->extension();
        Storage::disk('local')->assertExists($descriptorUrl);
        Storage::disk('local')->assertExists($organigramaUrl);

        $this->assertDatabaseHas('cargos', [
            'id' => Cargo::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'supervisor_id' => null,
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
            'area_id' => $parameters['area_id'],
            'estado' => $parameters['estado'],
            'organigrama_url' => $organigramaUrl,
            'descriptor_url' => $descriptorUrl,
            'nombre_fantasia' => $parameters['nombre_fantasia'],
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
            'nombre_fantasia' => $cargo->nombre_fantasia,
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
            'nombre_fantasia' => $parameters['nombre_fantasia'],
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
                            'estado' => 1,
                        ]);

        $url = '/api/cargos/'.$cargoPadre->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(409)
                    ->assertSeeText('El cargo tiene hijos.');
    }

    public function testEditarCargoSinOrganigramaAOrganigrama()
    {
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class, 1)->make());
                    });

        $supervisor = factory(Cargo::class)->create();

        Storage::fake('local');

        $organigrama = UploadedFile::fake()->create('organigrama123.pdf');
        $descriptor = UploadedFile::fake()->create('descriptor123.pdf');

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'nombre_fantasia' => 'Nuevo nombre de fantasia',
            'supervisor_id' => $supervisor->id,
            'organigrama' => $organigrama,
            'descriptor' => $descriptor,
            'area_id' => $cargos[0]->area_id,
            'nivel_jerarquico_id' => $cargos[0]->nivel_jerarquico_id,
            'estado' => 1,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $descriptorUrl = 'public/cargos/'.$cargos[0]->id.'_'.$parameters['nombre'].'_descriptor'.'.'.$descriptor->extension();
        $organigramaUrl = 'public/cargos/'.$cargos[0]->id.'_'.$parameters['nombre'].'_organigrama'.'.'.$organigrama->extension();

        Storage::disk('local')->assertExists($descriptorUrl);
        Storage::disk('local')->assertExists($organigramaUrl);

        $this->assertDatabaseHas('cargos', [
            'id' => $cargos[0]->id,
            'nombre' => $parameters['nombre'],
            'nombre_fantasia' => $parameters['nombre_fantasia'],
            'supervisor_id' => $parameters['supervisor_id'],
            'descriptor_url' => $descriptorUrl,
            'organigrama_url' => $organigramaUrl,
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
            'area_id' => $parameters['area_id'],
            'estado' => $parameters['estado'],
        ]);

        $this->assertDatabaseMissing('cargos', [
            'id' => $cargos[0]->id,
            'nombre' => $cargos[0]->nombre,
            'nombre_fantasia' => $cargos[0]->nombre_fantasia,
            'supervisor_id' => $cargos[0]->supervisor_id,
            'organigrama' => null,
            'organigrama_url' => null,
            'descriptor' => null,
            'descriptor_url' => null,
            'nivel_jerarquico_id' => $cargos[0]->nivel_jerarquico_id,
            'area_id' => $cargos[0]->area_id,
            'estado' => $cargos[0]->estado,
        ]);
    }

    public function testEditarCargoConOrganigramaAOtroOrganigrama()
    {
        $supervisor = factory(Cargo::class)->create();
        $cargoPrincipal = factory(Cargo::class)->create();

        $cargo = factory(Cargo::class)
                    ->make([
                        'supervisor_id' => $cargoPrincipal->id,
                    ]);

        Storage::fake('local');

        $organigramaAnterior = UploadedFile::fake()->create('organigrama123.pdf');
        $organigrama = UploadedFile::fake()->create('organigrama123.pdf');
        $descriptorAnterior = UploadedFile::fake()->create('descriptor123.pdf');
        $descriptor = UploadedFile::fake()->create('descriptor123.pdf');

        $cargo->organigrama = $organigramaAnterior;
        $cargo->organigrama_url = $cargo->saveFile($organigramaAnterior, 'organigrama');
        $cargo->descriptor = $descriptorAnterior;
        $cargo->descriptor_url = $cargo->saveFile($descriptorAnterior, 'descriptor');
        $cargo->save();

        $url = "/api/cargos/{$cargo->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'nombre_fantasia' => 'Nuevo Administrador de recursos humanos',
            'supervisor_id' => $supervisor->id,
            'organigrama' => $organigrama,
            'descriptor' => $descriptor,
            'area_id' => $cargo->area_id,
            'nivel_jerarquico_id' => $cargo->nivel_jerarquico_id,
            'estado' => 1,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $descriptorUrl = 'public/cargos/'.$cargo->id.'_'.$parameters['nombre'].'_descriptor'.'.'.$descriptor->extension();
        $organigramaUrl = 'public/cargos/'.$cargo->id.'_'.$parameters['nombre'].'_organigrama'.'.'.$organigrama->extension();

        Storage::disk('local')->assertExists($descriptorUrl);
        Storage::disk('local')->assertExists($organigramaUrl);

        $this->assertDatabaseHas('cargos', [
            'id' => $cargo->id,
            'nombre' => $parameters['nombre'],
            'nombre_fantasia' => $parameters['nombre_fantasia'],
            'supervisor_id' => $parameters['supervisor_id'],
            'descriptor_url' => $descriptorUrl,
            'organigrama_url' => $organigramaUrl,
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
            'area_id' => $parameters['area_id'],
            'estado' => $parameters['estado'],
        ]);

        $this->assertDatabaseMissing('cargos', [
            'id' => $cargo->id,
            'nombre' => $cargo->nombre,
            'nombre_fantasia' => $cargo->nombre_fantasia,
            'supervisor_id' => $cargo->supervisor_id,
            'organigrama' => $cargo->organigrama,
            'organigrama_url' => $cargo->orgranigrama_url,
            'descriptor' => $cargo->descriptor,
            'descriptor_url' => $cargo->descriptor_url,
            'nivel_jerarquico_id' => $cargo->nivel_jerarquico_id,
            'area_id' => $cargo->area_id,
            'estado' => $cargo->estado,
        ]);
    }

    public function testEditarCargoConOrganigramaASinOrganigrama()
    {
        $supervisor = factory(Cargo::class)->create();
        $cargoPrincipal = factory(Cargo::class)->create();
        $cargo = factory(Cargo::class)
                    ->create([
                        'supervisor_id' => null,
                    ]);

        Storage::fake('local');

        $organigramaAnterior = UploadedFile::fake()->create('organigrama123.pdf');
        $organigrama = UploadedFile::fake()->create('organigrama123.pdf');
        $descriptorAnterior = UploadedFile::fake()->create('descriptor123.pdf');
        $descriptor = UploadedFile::fake()->create('descriptor123.pdf');

        $cargo->update([
            'organigrama' => $organigramaAnterior,
            'organigrama_url' => $cargo->saveFile($organigramaAnterior, 'organigrama'),
            'descriptor' => $descriptorAnterior,
            'descriptor_url' => $cargo->saveFile($descriptorAnterior, 'descriptor'),
        ]);

        $organigramaUrl = $cargo->organigrama_url;
        $descriptorUrl = $cargo->descriptor_url;

        $url = "/api/cargos/{$cargo->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'nombre_fantasia' => '',
            'supervisor_id' => '',
            'organigrama' => '',
            'organigrama_url' => '',
            'descriptor' => '',
            'descriptor_url' => '',
            'supervisor_id' => $cargoPrincipal->id,
            'area_id' => $cargo->area_id,
            'nivel_jerarquico_id' => $cargo->nivel_jerarquico_id,
            'estado' => 1,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        Storage::disk('local')->assertMissing($descriptorUrl);
        Storage::disk('local')->assertMissing($organigramaUrl);

        $this->assertDatabaseHas('cargos', [
            'id' => $cargo->id,
            'nombre' => $parameters['nombre'],
            'nombre_fantasia' => null,
            'descriptor_url' => null,
            'descriptor' => '',
            'organigrama_url' => null,
            'organigrama' => '',
            'supervisor_id' => $parameters['supervisor_id'],
            'area_id' => $parameters['area_id'],
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
        ]);

        $this->assertDatabaseMissing('cargos', [
            'id' => $cargo->id,
            'nombre' => $cargo->nombre,
            'nombre_fantasia' => $cargo->nombre_fantasia,
            'organigrama' => $cargo->organigrama,
            'organigrama_url' => $cargo->orgranigrama_url,
            'descriptor' => $cargo->descriptor,
            'descriptor_url' => $cargo->descriptor_url,
            'supervisor_id' => null,
        ]);
    }

    public function testNoSePuedeCambiarDeSupervisorSiElCargoTieneHijos()
    {
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class, 1)->make());
                    });

        $cargoSupervisor = factory(Cargo::class)
                ->create();

        $cargoHijo = factory(Cargo::class)->create([
            'supervisor_id' => $cargos[0]->id,
            'estado' => 1,
        ]);

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'supervisor_id' => $cargoSupervisor->id,
            'area_id' => $cargos[0]->area_id,
            'nivel_jerarquico_id' => $cargos[0]->nivel_jerarquico_id,
            'estado' => 1,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El cargo tiene hijos.'));
    }

    public function testSePuedeCambiarElAreaDeUnCargoConHijos()
    {
        $cargoSupervisor = factory(Cargo::class)
                            ->create();

        $cargo = factory(Cargo::class)
                    ->create([
                        'supervisor_id' => $cargoSupervisor->id,
                        'estado' => 1,
                    ]);

        $cargoHijo = factory(Cargo::class)->create([
            'supervisor_id' => $cargo->id,
            'estado' => 1,
        ]);

        $area = factory(Area::class)
                ->create();

        $nivelJerarquico = factory(NivelJerarquico::class)
                        ->create();

        $url = "/api/cargos/{$cargo->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'nombre_fantasia' => 'Administrador de recursos humanos',
            'supervisor_id' => $cargo->supervisor_id,
            'area_id' => $area->id,
            'nivel_jerarquico_id' => $nivelJerarquico->id,
            'estado' => 1,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('cargos', [
            'id' => $cargo->id,
            'nombre' => $parameters['nombre'],
            'nombre_fantasia' => $parameters['nombre_fantasia'],
            'supervisor_id' => $parameters['supervisor_id'],
            'area_id' => $parameters['area_id'],
            'nivel_jerarquico_id' => $parameters['nivel_jerarquico_id'],
        ]);

        $this->assertDatabaseMissing('cargos', [
            'id' => $cargo->id,
            'nombre' => $cargo->nombre,
            'nombre_fantasia' => $cargo->nombre_fantasia,
            'supervisor_id' => $cargo->supervisor_id,
            'organigrama' => $cargo->organigrama,
            'organigrama_url' => $cargo->orgranigrama_url,
            'descriptor' => $cargo->descriptor,
            'descriptor_url' => $cargo->descriptor_url,
            'area_id' => $cargo->area_id,
            'nivel_jerarquico_id' => $cargo->nivel_jerarquico_id,
        ]);
    }

    public function testNoSePuedeDesactivarCargoSiTieneCargosHijos()
    {
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class)->create());
                        $cargo->save();
                    });

        $cargoSupervisor = factory(Cargo::class)
                ->create();

        $cargoHijo = factory(Cargo::class)->create([
            'supervisor_id' => $cargos[0]->id,
            'estado' => 1,
        ]);

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'supervisor_id' => $cargoSupervisor->id,
            'estado' => 0,
            'area_id' => $cargos[0]->area_id,
            'nivel_jerarquico_id' => $cargos[0]->nivel_jerarquico_id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El cargo tiene hijos.'));
    }

    public function testNoSePuedeDesactivarCargoSiTieneMovilidadActiva()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargos = factory(Cargo::class, 1)
                    ->create()
                    ->each(function ($cargo) {
                        $cargo->supervisor()->associate(factory(Cargo::class)->create());
                        $cargo->save();
                    });

        $cargoSupervisor = factory(Cargo::class)
                ->create();

        factory(Movilidad::class)->create([
            'cargo_id' => $cargos[0]->id,
            'estado' => 1,
            'colaborador_id' => $colaborador->id,
            'fecha_inicio' => now()->format('Y-m-d'),
        ]);

        $url = "/api/cargos/{$cargos[0]->id}";

        $parameters = [
            'nombre' => 'Administrador de recursos humanos',
            'nombre_fantasia' => 'Nuevo Administrador de recursos humanos',
            'supervisor_id' => $cargoSupervisor->id,
            'estado' => 0,
            'area_id' => $cargos[0]->area_id,
            'nivel_jerarquico_id' => $cargos[0]->nivel_jerarquico_id,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(409)
                ->assertSeeText(json_encode('El cargo esta asociada a movilidades.'));
    }

    public function testObtenerTodosLosPadresDeAreaDeUnCargo()
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

        $cargo = factory(Cargo::class)
                ->create([
                    'area_id' => $area->id,
                ]);

        $url = "/api/cargos/{$cargo->id}/relacionados";

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'padre_id',
                        'estado',
                        'tipoArea',
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosPadresDeUnCargo()
    {
        $cargoSupervisor = factory(Cargo::class)
                    ->create();

        $cargoPadre = factory(Cargo::class)
                    ->create([
                        'supervisor_id' => $cargoSupervisor->id,
                    ]);

        $cargo = factory(Cargo::class)
                        ->create([
                            'supervisor_id' => $cargoPadre->id,
                        ]);

        $url = "/api/cargos/{$cargo->id}/supervisores";

        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
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
                        'organigrama_url',
                        'descriptor_url',
                        'estado',
                        // 'area' => [
                        //     'id',
                        //     'nombre',
                        //     'estado',
                        // ],
                        'nombre_fantasia',
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosPadresDeAreaDeUnCargoEnCasoElAreaNoTengaHijos()
    {
        $area = factory(Area::class)
                        ->create();

        $cargo = factory(Cargo::class)
                ->create([
                    'area_id' => $area->id,
                ]);

        $url = "/api/cargos/{$cargo->id}/relacionados";

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
