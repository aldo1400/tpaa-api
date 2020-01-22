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
            'id' => Administrador::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'username'=>$parameters['username'],
            'estado' => 1,
        ]);
    }
}
