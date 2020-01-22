<?php

namespace Tests\Feature\Administradores;

use Tests\TestCase;
use App\Administrador;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase
{
    protected $administrador;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    
    public function setUp(): void
    {
        parent::setUp();

        $this->administrador = factory(Administrador::class)->create();
       
    }

    public function testObtenerAdmministradores()
    {
        factory(Administrador::class, 10)
                    ->create();

        $token = JWTAuth::fromUser($this->administrador);
        
        $url = '/api/administradores';

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])
                ->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(11, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'estado',
                        'username'
                    ],
                ],
            ]);
    }

    public function testObtenerUnAdministrador()
    {
        $administradores = factory(Administrador::class, 10)
                            ->create();

        $token = JWTAuth::fromUser($this->administrador);

        $url = '/api/administradores/'.$administradores[1]->id;

        $response = $this->withHeaders([
                        'Authorization' => 'Bearer '.$token,
                    ])
                    ->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $administradores[1]->id,
                        'nombre' => $administradores[1]->nombre,
                        'username' => $administradores[1]->username,
                        'estado' => $administradores[1]->estado,
                ],
            ]);
    }

    public function testCrearAdministrador()
    {
        $administrador = factory(Administrador::class)->make();

        $token = JWTAuth::fromUser($this->administrador);

        $url = '/api/administradores';

        $parameters = [
            'nombre' => $administrador->nombre,
            'username'=>$administrador->username,
            'password'=>'password',
            'estado'=>1
        ];

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                    ])
                    ->json('POST', $url, $parameters);
        
        $response->assertStatus(201);

        $this->assertDatabaseHas('administradores', [
            'nombre' => $parameters['nombre'],
            'username'=>$parameters['username'],
            'estado' => 1,
        ]);
    }

    public function testEditarAdministrador()
    {
        $administrador = factory(Administrador::class)
                        ->create([
                            'estado'=>1
                        ]);
        
        $token = JWTAuth::fromUser($this->administrador);


        $url = "/api/administradores/{$administrador->id}";

        $parameters = [
            'nombre' => 'FELIPE BRISEÑO',
            'username'=>'ADMI-BRISEF',
            'password'=>'nueva password',
            'estado'=>1
        ];

        $response = $this->withHeaders([
                        'Authorization' => 'Bearer '.$token,
                    ])
                    ->json('PUT', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('administradores', [
            'id'=>$administrador->id,
            'nombre' => $parameters['nombre'],
            'username'=>$parameters['username'],
            'estado' => 1,
        ]);

        $this->assertDatabaseMissing('administradores', [
            'id'=>$administrador->id,
            'nombre' => $administrador->nombre,
            'username'=>$administrador->username,
            'estado' => 1,
        ]);
    }
}
