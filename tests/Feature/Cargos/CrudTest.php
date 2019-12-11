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
    public function testObtenerUnDepartamento()
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
}
