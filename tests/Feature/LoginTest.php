<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Colaborador;
use App\Administrador;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginAdministradorActivo()
    {
        $admin = factory(Administrador::class)->create([
            'estado' => 1,
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => $admin->username,
            'password' => 'secret',
            'rol' => 'api',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(200)
            ->assertJsonStructure([
                        'token',
                        'token_type',
                        'expires_in',
                        'user',
            ]);
    }

    /**
     * A basic feature test example.
     */
    public function testAdministradorNoPuedeObtenerAlColaboradorLogeado()
    {
        $admin = factory(Administrador::class)->create([
            'estado' => 1,
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => $admin->username,
            'password' => 'secret',
            'rol' => 'api',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(200);
        $data = $response->json();
        $token = $data['token'];

        $url = '/api/colaborador';

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])
                ->json('GET', $url);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     */
    public function testLoginColaboradorActivo()
    {
        $colaborador = factory(Colaborador::class)->create([
            'estado' => 1,
            'usuario' => 'aldo1400',
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => $colaborador->usuario,
            'password' => 'secret',
            'rol' => 'colaboradores',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'token_type',
            'expires_in',
            'user',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function testColaboradorActivoNoEstaAutorizadoAListarAdministradores()
    {
        $colaborador = factory(Colaborador::class)->create([
            'estado' => 1,
            'usuario' => 'aldo1400',
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => $colaborador->usuario,
            'password' => 'secret',
            'rol' => 'colaboradores',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(200);
        $data = $response->json();
        $token = $data['token'];

        $url = '/api/administradores';

        $response = $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])
                ->json('GET', $url);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     */
    public function testValidarRutaProtegidaDeColaborador()
    {
        $url = '/api/administradores';

        $response = $this->json('GET', $url);

        $response->assertStatus(401);
    }

    /**
     * A basic feature test example.
     */
    public function testValidarLoginColaboradorActivo()
    {
        $colaborador = factory(Colaborador::class)->create([
            'estado' => 1,
            'usuario' => 'aldo1400',
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => $colaborador->usuario,
            'password' => 'secret',
            'rol' => '',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'rol',
        ]);

        $parameters = [
            'username' => '',
            'password' => '',
            'rol' => 'admins',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'username',
            'password',
            'rol',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function testLoginAdministradorInactivo()
    {
        $admin = factory(Administrador::class)->create([
            'estado' => 0,
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => '',
            'password' => '',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422);
    }

    /**
     * Test if user can logout trough internal api.
     */
    public function testLogoutAdministrador()
    {
        $admin = factory(Administrador::class)->create([
            'estado' => 1,
        ]);

        $token = JWTAuth::fromUser($admin);

        $parameters = [
            'rol' => 'api',
        ];

        $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])->json('POST', 'api/logout')
                    ->assertStatus(200)
                    ->assertJsonStructure(['message']);

        $this->assertGuest('api');
    }

    /**
     * Test if user can logout trough internal api.
     */
    public function testLogoutColaborador()
    {
        $colaborador = factory(Colaborador::class)->create([
            'estado' => 1,
        ]);

        $token = JWTAuth::fromUser($colaborador);

        $parameters = [
            'rol' => 'colaboradores',
        ];

        $this->withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])->json('POST', 'api/logout')
                    ->assertStatus(200)
                    ->assertJsonStructure(['message']);

        $this->assertGuest('api');
    }
}
