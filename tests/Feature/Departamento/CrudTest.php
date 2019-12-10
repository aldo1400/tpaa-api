<?php

namespace Tests\Feature\Departamento;

use Tests\TestCase;
use App\Departamento;

class CrudTest extends TestCase
{
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

        // $response = $this->json('GET', '/api/departamentos');
        // $response->assertStatus(200)
        //     ->assertJsonCount(3, 'data')
        //     ->assertJson([
        //         'data' => [
        //             '0' => ['id' => $departamentos[1]->id],
        //             '1' => ['id' => $departamentos[2]->id],
        //             '2' => ['id' => $departamentos[3]->id],
        //             '3' => ['id' => $departamentos[4]->id],
        //         ],
        //     ]);
    }
}
