<?php

namespace Tests\Feature\Departamento;

use Tests\TestCase;
use App\Departamento;

class CrudTest extends TestCase
{
    public function testObtenerDepartamentos()
    {
        $departamentos = factory(Departamento::class, 10)
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
}
