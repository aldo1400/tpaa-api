<?php

namespace Tests\Feature\Cargos;

use App\Cargo;
use Tests\TestCase;

class CrudTest extends TestCase
{
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
                            // 'nivel_jerarquico' => $cargos[1]->nivel_jerarquico,
                            'nombre' => $cargos[1]->nombre,
                            'supervisor_id' => '',
                    ],
                ]);
    }
}
