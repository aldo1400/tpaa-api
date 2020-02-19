<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Administrador;

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
        // $admin = factory(User::class)->create();

        $url = '/api/login/';

        $parameters = [
            'username' => $admin->username,
            'password' => 'secret',
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
    public function testLoginAdministradorInactivo()
    {
        $admin = factory(Administrador::class)->create([
            'estado' => 0,
        ]);

        $url = '/api/login/';

        $parameters = [
            'username' => $admin->username,
            'password' => 'secret',
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(422);
    }
}
