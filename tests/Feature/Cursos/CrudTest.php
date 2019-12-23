<?php

namespace Tests\Feature\Cursos;

use App\Curso;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerCursos()
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
                        'tipo',
                        'estado',
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnCargo()
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
                            'tipo' => $cursos[1]->tipo,
                            'estado' => $cursos[1]->estado,
                    ],
                ]);
    }

    public function testCrearCurso()
    {
        $curso = factory(Curso::class)->make();
        $url = '/api/cursos';

        $parameters = [
            'nombre' => $curso->nombre,
            'tipo' => $curso->tipo,
            'estado' => $curso->estado,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('cursos', [
            'id' => Curso::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'tipo' => $parameters['tipo'],
            'estado' => $parameters['estado'],
        ]);
    }

    public function testEditarCurso()
    {
        $curso = factory(Curso::class)->create([
            'estado' => 1,
        ]);

        $url = '/api/cursos/'.$curso->id;

        $parameters = [
            'nombre' => 'NUEVO CURSO DE BIOLOGIA',
            'tipo' => 1,
            'estado' => 1,
        ];

        $response = $this->json('PUT', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('cursos', [
            'id' => $curso->id,
            'nombre' => $parameters['nombre'],
            'tipo' => $parameters['tipo'],
            'estado' => $parameters['estado'],
        ]);

        $this->assertDatabaseMissing('cursos', [
            'id' => $curso->id,
            'nombre' => $curso->nombre,
            'tipo' => $curso->tipo,
            'estado' => $curso->estado,
        ]);
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
