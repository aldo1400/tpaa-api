<?php

namespace Tests\Feature\Movilidades;

use App\Cargo;
use App\Movilidad;
use Carbon\Carbon;
use Tests\TestCase;
use App\Colaborador;
use App\TipoMovilidad;

class CrudTest extends TestCase
{
    public function testObtenerUnaMovilidad()
    {
        $cargo = factory(Cargo::class)->create();

        $colaborador = factory(Colaborador::class)->create();

        $tipoMovilidad = TipoMovilidad::first();

        $movilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_termino' => null,
            'tipo_movilidad_id' => $tipoMovilidad,
            'estado' => 1,
        ]);

        $url = '/api/movilidades/'.$movilidad->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $movilidad->id,
                        'fecha_inicio' => $movilidad->fecha_inicio->format('Y-m-d'),
                        'fecha_termino' => '',
                        'estado' => $movilidad->estado,
                        'tipoMovilidad' => $movilidad->tipoMovilidad->only([
                            'id',
                            'tipo',
                        ]),
                        'observaciones' => $movilidad->observaciones,
                        'cargo_id' => $movilidad->cargo->id,
                        'cargo_nombre' => $movilidad->cargo->nombre,
                        'colaborador_id' => $movilidad->colaborador->id,
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearPrimeraMovilidadDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::first(); //Nuevo (a)

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

        $tipoMovilidad = TipoMovilidad::where('tipo', 'Movilidad')->first();

        $parameters = [
            'fecha_termino' => '',
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'observaciones' => 'NINGUNA OBSERVACION',
            'cargo_id' => $cargo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);

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
                            'estado' => 1,
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
            'cargo_id' => '',
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
            'estado' => 0,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearSegundaMovilidadAUnColaboradorDeTipoTerminoDeContrato()
    {
        $colaborador = factory(Colaborador::class)->create([
                            'estado' => 1,
                        ]);

        $cargoAnterior = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::TERMINO_DE_CONTRATO)->first();

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
            'cargo_id' => '',
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
            'estado' => 0,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testNoSePuedeCrearSegundaMovilidadAUnColaboradorDeTipoRenunciaSiEnviaCargoID()
    {
        $colaborador = factory(Colaborador::class)->create([
                            'estado' => 1,
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
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('El cargo es inválido.'));
    }

    /**
     * A basic test example.
     */
    public function testNoSePuedeCrearSegundaMovilidadAUnColaboradorDeTipoTerminoDeCargoSiEnviaCargoID()
    {
        $colaborador = factory(Colaborador::class)->create([
                            'estado' => 1,
                        ]);

        $cargoAnterior = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::TERMINO_DE_CONTRATO)->first();

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

        $url = '/api/movilidades/'.$movilidad->id;

        $response = $this->json('DELETE', $url);

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

    /**
     * A basic test example.
     */
    public function testEditarMovilidadActivaDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidadDesarrollo = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();
        $tipoMovilidadNuevo = TipoMovilidad::where('tipo', TipoMovilidad::NUEVO)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadNuevo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '03', '05')->format('Y-m-d'),
        ]);

        $segundaMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '05', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '07', '05')->format('Y-m-d'),
        ]);

        $terceraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '07', '06')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '08', '01')->format('Y-m-d'),
        ]);

        $cuartaMovilidad = factory(Movilidad::class)->create([
            'fecha_inicio' => Carbon::createFromDate('2018', '08', '05')->format('Y-m-d'),
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 1,
            'fecha_termino' => null,
        ]);

        $parameters = [
            'fecha_termino' => null,
            'fecha_inicio' => Carbon::createFromDate('2018', '08', '02')->format('Y-m-d'),
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/movilidades/'.$cuartaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('movilidades', [
            'id' => $cuartaMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $parameters['cargo_id'],
            'estado' => 1,
            'fecha_termino' => null,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'tipo_movilidad_id' => $cuartaMovilidad->tipoMovilidad->id,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarFechaDeInicioSeaMenorQueFechaDeTerminoAlEditarMovilidadDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();

        $movilidades = factory(Movilidad::class, 2)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'estado' => 0,
        ]);

        $movilidad = factory(Movilidad::class)->create([
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_termino' => now()->addDays(3)->format('Y-m-d'),
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidad->id,
            'estado' => 1,
            'fecha_termino' => null,
        ]);

        $parameters = [
            'fecha_inicio' => now()->addDays(3)->format('Y-m-d'),
            'fecha_termino' => now()->addDays(1)->format('Y-m-d'),
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/movilidades/'.$movilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('Fecha de termino debe ser mayor a la fecha de inicio de la movilidad.'));
    }

    /**
     * A basic test example.
     */
    public function testValidarFechaDeInicioYFechaDeTerminoAlEditarMovilidadDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidadDesarrollo = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();
        $tipoMovilidadNuevo = TipoMovilidad::where('tipo', TipoMovilidad::NUEVO)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadNuevo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '03', '05')->format('Y-m-d'),
        ]);

        $segundaMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '05', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '07', '05')->format('Y-m-d'),
        ]);

        $terceraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '07', '06')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '08', '01')->format('Y-m-d'),
        ]);

        $cuartaMovilidad = factory(Movilidad::class)->create([
            'fecha_inicio' => Carbon::createFromDate('2018', '08', '05')->format('Y-m-d'),
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 1,
            'fecha_termino' => null,
        ]);

        $parameters = [
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '15')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '03', '01')->format('Y-m-d'),
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('Fecha de inicio y termino de movilidad inválidas.'));

        $parameters = [
                    'fecha_inicio' => Carbon::createFromDate('2018', '01', '05')->format('Y-m-d'),
                    'fecha_termino' => Carbon::createFromDate('2018', '03', '01')->format('Y-m-d'),
                    'observaciones' => 'SUBIO DE GRADO',
                    'cargo_id' => $cargoNuevo->id,
                ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
                                ->assertSeeText(json_encode('Fecha de inicio y termino de movilidad inválidas.'));

        $parameters = [
                    'fecha_inicio' => Carbon::createFromDate('2018', '01', '05')->format('Y-m-d'),
                    'fecha_termino' => Carbon::createFromDate('2019', '10', '01')->format('Y-m-d'),
                    'observaciones' => 'SUBIO DE GRADO',
                    'cargo_id' => $cargoNuevo->id,
                ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
                ->assertSeeText(json_encode('Fecha de inicio y termino de movilidad inválidas.'));

        $parameters = [
                    'fecha_inicio' => Carbon::createFromDate('2018', '01', '05')->format('Y-m-d'),
                    'fecha_termino' => Carbon::createFromDate('2018', '08', '04')->format('Y-m-d'),
                    'observaciones' => 'SUBIO DE GRADO',
                    'cargo_id' => $cargoNuevo->id,
                ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
                ->assertSeeText(json_encode('Fecha de inicio y termino de movilidad inválidas.'));

        $parameters = [
                    'fecha_inicio' => Carbon::createFromDate('2018', '01', '05')->format('Y-m-d'),
                    'fecha_termino' => Carbon::createFromDate('2018', '07', '24')->format('Y-m-d'),
                    'observaciones' => 'SUBIO DE GRADO',
                    'cargo_id' => $cargoNuevo->id,
                ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
                ->assertSeeText(json_encode('Fecha de inicio y termino de movilidad inválidas.'));
    }

    /**
     * A basic test example.
     */
    public function testEditarMovilidadInactivaDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidadDesarrollo = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();
        $tipoMovilidadNuevo = TipoMovilidad::where('tipo', TipoMovilidad::NUEVO)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadNuevo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '03', '05')->format('Y-m-d'),
        ]);

        $segundaMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '05', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '07', '05')->format('Y-m-d'),
        ]);

        $terceraMovilidad = factory(Movilidad::class)->create([
            'fecha_inicio' => Carbon::createFromDate('2018', '08', '05')->format('Y-m-d'),
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 1,
            'fecha_termino' => null,
        ]);

        $parameters = [
            'fecha_inicio' => Carbon::createFromDate('2018', '04', '05')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '06', '05')->format('Y-m-d'),
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('movilidades', [
            'id' => $segundaMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $parameters['cargo_id'],
            'estado' => 0,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => $parameters['fecha_termino'],
            'tipo_movilidad_id' => $segundaMovilidad->tipoMovilidad->id,
        ]);

        $this->assertDatabaseMissing('movilidades', [
            'id' => $segundaMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $segundaMovilidad->cargo_id,
            'estado' => 0,
            'fecha_inicio' => $segundaMovilidad->fecha_inicio,
            'fecha_termino' => $segundaMovilidad->fecha_termino,
            'tipo_movilidad_id' => $segundaMovilidad->tipoMovilidad->id,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarMovilidadInactivaDeUnColaboradorConElMismoValor()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cargo = factory(Cargo::class)->create();
        $cargoNuevo = factory(Cargo::class)->create();

        $tipoMovilidadDesarrollo = TipoMovilidad::where('tipo', TipoMovilidad::DESARROLLO)->first();
        $tipoMovilidadNuevo = TipoMovilidad::where('tipo', TipoMovilidad::NUEVO)->first();

        $primeraMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadNuevo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '01')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '02', '02')->format('Y-m-d'),
        ]);

        $segundaMovilidad = factory(Movilidad::class)->create([
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 0,
            'fecha_inicio' => Carbon::createFromDate('2018', '05', '02')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '05', '05')->format('Y-m-d'),
        ]);

        $terceraMovilidad = factory(Movilidad::class)->create([
            'fecha_inicio' => Carbon::createFromDate('2018', '08', '10')->format('Y-m-d'),
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $cargo->id,
            'tipo_movilidad_id' => $tipoMovilidadDesarrollo->id,
            'estado' => 1,
            'fecha_termino' => null,
        ]);

        $parameters = [
            'fecha_inicio' => Carbon::createFromDate('2018', '05', '02')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2018', '05', '05')->format('Y-m-d'),
            'observaciones' => 'SUBIO DE GRADO',
            'cargo_id' => $cargoNuevo->id,
        ];

        $url = '/api/movilidades/'.$segundaMovilidad->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('movilidades', [
            'id' => $segundaMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $parameters['cargo_id'],
            'estado' => 0,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => $parameters['fecha_termino'],
            'tipo_movilidad_id' => $segundaMovilidad->tipoMovilidad->id,
        ]);

        $this->assertDatabaseMissing('movilidades', [
            'id' => $segundaMovilidad->id,
            'colaborador_id' => $colaborador->id,
            'cargo_id' => $segundaMovilidad->cargo_id,
            'estado' => 0,
            'fecha_inicio' => $segundaMovilidad->fecha_inicio,
            'fecha_termino' => $segundaMovilidad->fecha_termino,
            'tipo_movilidad_id' => $segundaMovilidad->tipoMovilidad->id,
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
