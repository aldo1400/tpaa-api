<?php

namespace Tests\Feature\Departamento;

use Tests\TestCase;
use App\Departamento;

class CrudTest extends TestCase
{
    public function testObtenerDepartamentos()
    {
        factory(Departamento::class, 10)
                    ->create();

        $url = '/api/departamentos';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'tipo',
                        'nombre',
                    ],
                ],
            ]);
    }

    public function testObtenerUnDepartamento()
    {
        $departamentos = factory(Departamento::class, 10)
                    ->create();

        $url = '/api/departamentos/'.$departamentos[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $departamentos[1]->id,
                        'tipo' => $departamentos[1]->tipo,
                        'nombre' => $departamentos[1]->nombre,
                        'padre_id' => '',
                ],
            ]);
    }

    public function testCrearDepartamentoSinPadre()
    {
        $departamento = factory(Departamento::class)->make();
        $url = '/api/departamentos';
        $parameters = [
            'tipo' => $departamento->tipo,
            'nombre' => $departamento->nombre,
            'padre_id' => '',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('departamentos', [
            'id' => Departamento::latest()->first()->id,
            'tipo' => $parameters['tipo'],
            'nombre' => $parameters['nombre'],
            'padre_id' => null,
        ]);
    }

    public function testValidarCrearDepartamentoSinPadre()
    {
        $departamento = factory(Departamento::class)->make();
        $url = '/api/departamentos';
        $parameters = [
            'tipo' => '',
            'nombre' => '',
            'padre_id' => '',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'tipo',
                'nombre',
            ]);

        $parameters = [
                'tipo' => 'OTRO TIPO',
                'nombre' => $departamento->nombre,
                'padre_id' => '99999',
            ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'tipo',
                    'padre_id',
                ]);
    }

    public function testCrearDepartamentoConPadre()
    {
        $departamentoPadre = factory(Departamento::class)->make();
        $departamento = factory(Departamento::class)->make();
        $url = '/api/departamentos';
        $parameters = [
            'tipo' => $departamento->tipo,
            'nombre' => $departamento->nombre,
            'padre_id' => $departamentoPadre->id,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('departamentos', [
            'id' => Departamento::latest()->first()->id,
            'tipo' => $parameters['tipo'],
            'nombre' => $parameters['nombre'],
            'padre_id' => $parameters['padre_id'],
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEliminarDepartamento()
    {
        $departamentos = factory(Departamento::class, 5)
                    ->create();

        $url = '/api/departamentos/'.$departamentos[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('departamentos', [
            'id' => $departamentos[0]->id,
        ]);

        $response = $this->json('GET', '/api/departamentos');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $departamentos[1]->id],
                    '1' => ['id' => $departamentos[2]->id],
                    '2' => ['id' => $departamentos[3]->id],
                    '3' => ['id' => $departamentos[4]->id],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarQueUnDepartamentoConDepartamentosInferioresNoPuedeSerEliminado()
    {
        $departamentoPadre = factory(Departamento::class)
                        ->create();

        $departamento = factory(Departamento::class)
                        ->create([
                            'padre_id' => $departamentoPadre->id,
                        ]);

        $url = '/api/departamentos/'.$departamentoPadre->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(409)
                    ->assertSeeText('El departamento tiene hijos.');
    }

    public function testEditarDepartamento()
    {
        $departamento = factory(Departamento::class)
                        ->create([
                            'tipo' => Departamento::GERENCIA_GENERAL,
                        ]);

        $url = "/api/departamentos/{$departamento->id}";

        $parameters = [
            'nombre' => 'Area de administración de recursos humanos',
            'tipo' => Departamento::GERENCIA,
        ];

        $response = $this->json('PATCH', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('departamentos', [
            'id' => $departamento->id,
            'nombre' => $parameters['nombre'],
            'tipo' => $departamento->tipo,
        ]);

        $this->assertDatabaseMissing('departamentos', [
            'id' => $departamento->id,
            'nombre' => $departamento->nombre,
        ]);
    }
}
