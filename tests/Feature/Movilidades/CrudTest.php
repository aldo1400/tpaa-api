<?php

namespace Tests\Feature\Movilidades;

use App\Cargo;
use App\Movilidad;
use Tests\TestCase;
use App\Colaborador;
use App\TipoMovilidad;

class CrudTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testCrearPrimeraMovilidadDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::first();//Nuevo (a)

        $parameters = [
            'fecha_termino' => '',
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'observaciones' => 'NINGUNA OBSERVACION',
            // 'estado' => 1,
            'cargo_id' => $cargo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $this->assertDatabaseHas('movilidades', [
            'id' => Movilidad::latest()->first()->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'estado' => 1,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => null,
            'tipo_movilidad_id' => $parameters['tipo_movilidad_id'],
            'observaciones' => $parameters['observaciones'],
        ]);
    }

    public function testLaPrimeraMovilidadDeUnColaboradorDebeSerSiempreNuevo()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo','Movilidad')->first();

        $parameters = [
            'fecha_termino' => '',
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'observaciones' => 'NINGUNA OBSERVACION',
            'cargo_id' => $cargo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('El tipo de movilidad es inválido.'));
    }

    /**
     * A basic test example.
     */
    public function testCrearSegundaMovilidadAUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargoAnterior = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargoAnterior->id,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_termino' => null,
            'tipo_movilidad_id' => 1,
        ]);

        $parameters = [
            'fecha_termino' => now()->addDays(1)->format('Y-m-d'),
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('movilidades', [
            'id' => $primeraMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargoAnterior->id,
            'estado' => 0,
            'fecha_inicio' => $primeraMovilidad->fecha_inicio,
            'fecha_termino' => $parameters['fecha_termino'],
            'observaciones' => null,
            'tipo_movilidad_id' => 1,
        ]);

        $this->assertDatabaseHas('movilidades', [
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $parameters['cargo_id'],
            'estado' => 1,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => null,
            'tipo_movilidad_id' => $parameters['tipo_movilidad_id'],
            'observaciones' => $parameters['observaciones'],
        ]);
    }

     /**
     * A basic test example.
     */
    public function testCrearSegundaMovilidadAUnColaboradorDeTipoRenuncia()
    {
        $colaborador = factory(Colaborador::class)->create([
                            'estado'=>1
                        ]);

        $cargoAnterior = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::RENUNCIA)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargoAnterior->id,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_termino' => null,
            'tipo_movilidad_id' => 1,
        ]);

        $parameters = [
            'fecha_termino' => now()->addDays(1)->format('Y-m-d'),
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' =>'',
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('movilidades', [
            'id' => $primeraMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargoAnterior->id,
            'estado' => 0,
            'fecha_inicio' => $primeraMovilidad->fecha_inicio,
            'fecha_termino' => $parameters['fecha_termino'],
            'observaciones' => null,
            'tipo_movilidad_id' => 1,
        ]);

        $this->assertDatabaseHas('movilidades', [
            'colaborador_id' => $colaborador->id,
            'cargo_id' => null,
            'estado' => 1,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => null,
            'tipo_movilidad_id' => $parameters['tipo_movilidad_id'],
            'observaciones' => $parameters['observaciones'],
        ]);

        $this->assertDatabaseHas('colaboradores', [
            'id' => $colaborador->id,
            'estado'=>0
        ]);
    }

      /**
     * A basic test example.
     */
    public function testNoSePuedeCrearSegundaMovilidadAUnColaboradorDeTipoRenunciaSiEnviaCargoID()
    {
        $colaborador = factory(Colaborador::class)->create([
                            'estado'=>1
                        ]);

        $cargoAnterior = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::RENUNCIA)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargoAnterior->id,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_termino' => null,
            'tipo_movilidad_id' => 1,
        ]);

        $parameters = [
            'fecha_termino' => now()->addDays(1)->format('Y-m-d'),
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' =>$cargoNuevo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('El cargo es inválido.'));
    }

    /**
     * A basic test example.
     */
    public function testEliminarMovilidadDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();

        $movilidades = factory(Movilidad::class, 3)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'estado' => 0,
        ]);

        $movilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'estado' => 1,
        ]);

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('DELETE', $url);
        // dd($response->decodeResponseJson());
        $response->assertStatus(200);

        $this->assertSoftDeleted('movilidades', [
            'id' => $movilidad->id,
        ]);

        $this->assertDatabaseHas('movilidades', [
            'id' => $movilidades[2]->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'estado' => 1,
            'fecha_termino' => null,
        ]);
    }

    public function testObtenerTodasLasMovilidadDeUnColaborador()
    {
        $cargo = factory(Cargo::class)->create();

        $colaboradores = factory(Colaborador::class, 2)
                        ->create()
                        ->each(function ($colaborador) use ($cargo) {
                            $colaborador->movilidades()->saveMany(factory(Movilidad::class, 2)
                                        ->make([
                                            'cargo_id' => $cargo->id,
                                        ]));
                        });

        $url = '/api/colaboradores/'.$colaboradores[0]->id.'/movilidades';

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
                ->assertJsonCount(2, 'data')
                    ->assertJsonStructure([
                        'data' => [
                            '*' => [
                                'id',
                                'cargo_id',
                                'cargo_nombre',
                                'colaborador_id',
                                'tipoMovilidad' => [
                                    'id',
                                    'tipo',
                                    'estado',
                                ],
                            ],
                        ],
                    ]);
    }
}
