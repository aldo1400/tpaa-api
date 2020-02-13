<?php

namespace Tests\Feature\Notificaciones;

use Tests\TestCase;
use App\Colaborador;
use App\Notificacion;

class GetTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testObtenerTodasLasNotificaciones()
    {
        factory(Notificacion::class, 10)
                    ->create();

        $url = '/api/notificaciones';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'tipo',
                        'mensaje',
                        'colaborador' => [
                            'id',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerTodasLasNotificacionesDeUnColaborador()
    {
        $colaboradores = factory(Colaborador::class, 3)
                        ->create()
                        ->each(function ($colaborador) {
                            $colaborador->notificaciones()->saveMany(factory(Notificacion::class, 3)->make());
                        });

        $url = '/api/colaboradores/'.$colaboradores[1]->id.'/notificaciones';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        '0' => [
                            'id' => $colaboradores[1]->notificaciones[0]->id,
                            'tipo' => $colaboradores[1]->notificaciones[0]->tipo,
                            'mensaje' => $colaboradores[1]->notificaciones[0]->mensaje,
                        ],
                        '1' => [
                            'id' => $colaboradores[1]->notificaciones[1]->id,
                            'tipo' => $colaboradores[1]->notificaciones[1]->tipo,
                            'mensaje' => $colaboradores[1]->notificaciones[1]->mensaje,
                        ],
                        '2' => [
                            'id' => $colaboradores[1]->notificaciones[2]->id,
                            'tipo' => $colaboradores[1]->notificaciones[2]->tipo,
                            'mensaje' => $colaboradores[1]->notificaciones[2]->mensaje,
                        ],
                    ],
                ]);
    }
}
