<?php

namespace Tests\Feature\Cursos;

use App\Curso;
use App\TipoCurso;
use Carbon\Carbon;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerTodosLosCursos()
    {
        factory(Curso::class, 10)
                    ->create();

        $url = '/api/cursos';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'titulo',
                        'horas_cronologicas',
                        'realizado',
                        'fecha_inicio',
                        'fecha_termino',
                        'estado',
                        'anio',
                        'interno',
                        'tipoCurso' => [
                            'id',
                            'categoria',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosCursosActivosEInternos()
    {
        factory(Curso::class, 8)
                    ->create([
                        'estado' => 1,
                        'interno' => 1,
                    ]);

        factory(Curso::class, 10)
                    ->create([
                        'estado' => 1,
                        'interno' => 0,
                    ]);

        $url = '/api/cursos?interno=true';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(8, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'titulo',
                        'horas_cronologicas',
                        'realizado',
                        'fecha_inicio',
                        'fecha_termino',
                        'estado',
                        'anio',
                        'interno',
                        'tipoCurso' => [
                            'id',
                            'categoria',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosCursosActivos()
    {
        factory(Curso::class, 2)
                    ->create([
                        'estado' => 1,
                    ]);

        factory(Curso::class, 4)
                    ->create([
                        'estado' => 0,
                    ]);

        $url = '/api/cursos?estado=true';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'titulo',
                        'horas_cronologicas',
                        'realizado',
                        'fecha_inicio',
                        'fecha_termino',
                        'estado',
                        'anio',
                        'interno',
                        'tipoCurso' => [
                            'id',
                            'categoria',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosCursosInactivos()
    {
        factory(Curso::class, 2)
                    ->create([
                        'estado' => 1,
                    ]);

        factory(Curso::class, 4)
                    ->create([
                        'estado' => 0,
                    ]);

        $url = '/api/cursos?estado=false';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'titulo',
                        'horas_cronologicas',
                        'realizado',
                        'fecha_inicio',
                        'fecha_termino',
                        'estado',
                        'anio',
                        'interno',
                        'tipoCurso' => [
                            'id',
                            'categoria',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnCurso()
    {
        $cursos = factory(Curso::class, 10)
                        ->create();

        $url = '/api/cursos/'.$cursos[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                            'id' => $cursos[1]->id,
                            'nombre' => $cursos[1]->nombre,
                            'titulo' => $cursos[1]->titulo,
                            'horas_cronologicas' => $cursos[1]->horas_cronologicas,
                            'realizado' => $cursos[1]->realizado,
                            'fecha_inicio' => $cursos[1]->fecha_inicio->format('Y-m-d'),
                            'fecha_termino' => $cursos[1]->fecha_termino->format('Y-m-d'),
                            'estado' => $cursos[1]->estado,
                            'anio' => $cursos[1]->anio,
                            'interno' => $cursos[1]->interno,
                            'tipoCurso' => $cursos[1]->tipoCurso->only([
                                'id',
                                'categoria',
                            ]),
                    ],
                ]);
    }

    public function testCrearCurso()
    {
        $curso = factory(Curso::class)->make();
        $tipoCurso = factory(TipoCurso::class)->create();
        $url = '/api/cursos';

        $parameters = [
            'nombre' => $curso->nombre,
            'titulo' => $curso->titulo,
            'horas_cronologicas' => $curso->horas_cronologicas,
            'realizado' => $curso->realizado,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '10')->format('Y-m-d'),
            'fecha_termino' => now()->format('Y-m-d'),
            'tipo_curso_id' => $tipoCurso->id,
            'estado' => 1,
            'interno' => 1,
            'anio' => '2018',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('cursos', [
            'id' => Curso::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'titulo' => $parameters['titulo'],
            'horas_cronologicas' => $parameters['horas_cronologicas'],
            'realizado' => $parameters['realizado'],
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => $parameters['fecha_termino'],
            'tipo_curso_id' => $parameters['tipo_curso_id'],
            'interno' => $parameters['interno'],
            'anio' => $parameters['anio'],
            'estado' => $parameters['estado'],
        ]);
    }

    public function testValidarQueFechaDeTerminoSeaMayorQueLaFechaDeInicioDelCurso()
    {
        $curso = factory(Curso::class)->make();
        $tipoCurso = factory(TipoCurso::class)->create();
        $url = '/api/cursos';

        $parameters = [
            'nombre' => $curso->nombre,
            'titulo' => $curso->titulo,
            'horas_cronologicas' => $curso->horas_cronologicas,
            'realizado' => $curso->realizado,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '10')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2017', '02', '10')->format('Y-m-d'),
            'tipo_curso_id' => $tipoCurso->id,
            'estado' => 1,
            'interno' => 1,
            'anio' => '2018',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('Fecha de termino debe ser mayor a la fecha de inicio del curso.'));
    }

    public function testCrearCursoSinFechaTermino()
    {
        $curso = factory(Curso::class)->make();
        $tipoCurso = factory(TipoCurso::class)->create();
        $url = '/api/cursos';

        $parameters = [
            'nombre' => $curso->nombre,
            'titulo' => $curso->titulo,
            'horas_cronologicas' => $curso->horas_cronologicas,
            'realizado' => $curso->realizado,
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'fecha_termino' => now()->addDays(3)->format('Y-m-d'),
            'tipo_curso_id' => $tipoCurso->id,
            'estado' => 1,
            'interno' => 1,
            'anio' => '2018',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('cursos', [
            'id' => Curso::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'titulo' => $parameters['titulo'],
            'horas_cronologicas' => $parameters['horas_cronologicas'],
            'realizado' => $parameters['realizado'],
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => $parameters['fecha_termino'],
            'tipo_curso_id' => $parameters['tipo_curso_id'],
            'interno' => $parameters['interno'],
            'anio' => $parameters['anio'],
            'estado' => $parameters['estado'],
        ]);
    }

    public function testEditarCurso()
    {
        $curso = factory(Curso::class)->create([
            'estado' => 1,
        ]);

        $tipoCurso = factory(TipoCurso::class)
                    ->create();

        $url = '/api/cursos/'.$curso->id;

        $parameters = [
            'nombre' => 'NUEVO CURSO DE BIOLOGIA',
            'titulo' => 'BIOLOGIA 2020',
            'horas_cronologicas' => $curso->horas_cronologicas,
            'realizado' => $curso->realizado,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '01')->format('Y-m-d'),
            'fecha_termino' => now()->format('Y-m-d'),
            'tipo_curso_id' => $tipoCurso->id,
            'estado' => 1,
            'interno' => 1,
            'anio' => '2020',
        ];

        $response = $this->json('PUT', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('cursos', [
            'id' => $curso->id,
            'nombre' => $parameters['nombre'],
            'titulo' => $parameters['titulo'],
            'horas_cronologicas' => $parameters['horas_cronologicas'],
            'realizado' => $parameters['realizado'],
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => $parameters['fecha_termino'],
            'tipo_curso_id' => $parameters['tipo_curso_id'],
            'interno' => $parameters['interno'],
            'anio' => $parameters['anio'],
            'estado' => $parameters['estado'],
        ]);

        $this->assertDatabaseMissing('cursos', [
            'id' => $curso->id,
            'nombre' => $curso->nombre,
            'titulo' => $curso->titulo,
            'horas_cronologicas' => $curso->horas_cronologicas,
            'realizado' => $curso->realizado,
            'fecha_inicio' => $curso->fecha_inicio,
            'fecha_termino' => $curso->fecha_termino,
            'tipo_curso_id' => $curso->tipo_curso_id,
            'interno' => $curso->interno,
            'anio' => $curso->anio,
            'estado' => $curso->estado,
        ]);
    }

    public function testValidarFechaAlEditarCurso()
    {
        $curso = factory(Curso::class)->create([
            'estado' => 1,
        ]);

        $tipoCurso = factory(TipoCurso::class)
                    ->create();

        $url = '/api/cursos/'.$curso->id;

        $parameters = [
            'nombre' => 'NUEVO CURSO DE BIOLOGIA',
            'titulo' => 'BIOLOGIA 2020',
            'horas_cronologicas' => $curso->horas_cronologicas,
            'realizado' => $curso->realizado,
            'fecha_inicio' => Carbon::createFromDate('2018', '02', '01')->format('Y-m-d'),
            'fecha_termino' => Carbon::createFromDate('2017', '02', '10')->format('Y-m-d'),
            'tipo_curso_id' => $tipoCurso->id,
            'estado' => 1,
            'interno' => 1,
            'anio' => '2020',
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
        ->assertSeeText(json_encode('Fecha de termino debe ser mayor a la fecha de inicio del curso.'));
    }

    /**
     * A basic test example.
     */
    public function testEliminarCurso()
    {
        $cursos = factory(Curso::class, 5)
                    ->create();

        $url = '/api/cursos/'.$cursos[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('cursos', [
            'id' => $cursos[0]->id,
        ]);

        $response = $this->json('GET', '/api/cursos');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $cursos[1]->id],
                    '1' => ['id' => $cursos[2]->id],
                    '2' => ['id' => $cursos[3]->id],
                    '3' => ['id' => $cursos[4]->id],
                ],
            ]);
    }
}
