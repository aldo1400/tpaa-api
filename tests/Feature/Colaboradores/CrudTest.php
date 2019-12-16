<?php

namespace Tests\Feature\Colaboradores;

use Tests\TestCase;
use App\Colaborador;
use App\Departamento;

class CrudTest extends TestCase
{
    public function testObtenerUnColaborador()
    {
        $colaboradores = factory(Colaborador::class, 10)
                        ->create();

        $departamento = factory(Departamento::class)
                        ->create([
                            'tipo' => Departamento::GERENCIA_GENERAL,
                        ]);

        $colaboradores[1]->gerencia()->associate($departamento->id);
        // dd($colaboradores[1]->gerencia_id);
        $colaboradores[1]->save();

        $url = '/api/colaboradores/'.$colaboradores[1]->id;
        $response = $this->json('GET', $url);

        // dd($response->decodeResponseJson());
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $colaboradores[1]->id,
                        'rut' => $colaboradores[1]->rut,
                        'usuario' => $colaboradores[1]->usuario,
                        'nombres' => $colaboradores[1]->nombres,
                        'apellidos' => $colaboradores[1]->apellidos,
                        'sexo' => $colaboradores[1]->sexo,
                        'nacionalidad' => $colaboradores[1]->nacionalidad,
                        'estado_civil' => $colaboradores[1]->estado_civil,
                        'fecha_nacimiento' => $colaboradores[1]->fecha_nacimiento->format('d-m-Y'),
                        'edad' => $colaboradores[1]->edad,
                        'email' => $colaboradores[1]->email,
                        'nivel_educacion' => $colaboradores[1]->nivel_educacion,
                        'domicilio' => $colaboradores[1]->domicilio,
                        'licencia_b' => $colaboradores[1]->licencia_b,
                        'vencimiento_licencia_b' => $colaboradores[1]->vencimiento_licencia_b->format('d-m-Y'),
                        'licencia_d' => $colaboradores[1]->licencia_d,
                        'vencimiento_licencia_d' => $colaboradores[1]->vencimiento_licencia_d->format('d-m-Y'),
                        'carnet_portuario' => $colaboradores[1]->carnet_portuario,
                        'vencimiento_carnet_portuario' => $colaboradores[1]->vencimiento_carnet_portuario->format('d-m-Y'),
                        'talla_calzado' => $colaboradores[1]->talla_calzado,
                        'talla_chaleco' => $colaboradores[1]->talla_chaleco,
                        'talla_polera' => $colaboradores[1]->talla_polera,
                        'talla_pantalon' => $colaboradores[1]->talla_pantalon,
                        'fecha_ingreso' => $colaboradores[1]->fecha_ingreso->format('d-m-Y'),
                        'telefono' => $colaboradores[1]->telefono,
                        'celular' => $colaboradores[1]->celular,
                        'anexo' => $colaboradores[1]->anexo,
                        'contacto_emergencia_nombre' => $colaboradores[1]->contacto_emergencia_nombre,
                        'contacto_emergencia_telefono' => $colaboradores[1]->contacto_emergencia_telefono,
                        'estado' => $colaboradores[1]->estado,
                        'fecha_inactividad' => $colaboradores[1]->fecha_inactividad->format('d-m-Y'),
                        'gerencia_id' => $colaboradores[1]->gerencia->only([
                            'id',
                            'tipo',
                            'nombre',
                        ]),
                        'subgerencia_id' => '',
                        'area_id' => '',
                        'subarea_id' => '',
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearColaboradorSinDepartamento()
    {
        $colaborador = factory(Colaborador::class)->make();
        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'estado_civil' => $colaborador->estado_civil,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('Y-m-d'),
            'edad' => $colaborador->edad,
            'email' => $colaborador->email,
            'nivel_educacion' => $colaborador->nivel_educacion,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'nombres' => $parameters['nombres'],
            'apellidos' => $parameters['apellidos'],
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'estado_civil' => $parameters['estado_civil'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => $parameters['edad'],
            'email' => $parameters['email'],
            'nivel_educacion' => $parameters['nivel_educacion'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => $parameters['carnet_portuario'],
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $parameters['estado'],
            'fecha_inactividad' => null,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearColaboradorConDepartamentoGerencia()
    {
        $colaborador = factory(Colaborador::class)->make();
        $departamento = factory(Departamento::class)->create([
            'tipo' => Departamento::GERENCIA_GENERAL,
        ]);
        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => '',
            'estado_civil' => '',
            'fecha_nacimiento' => '',
            'edad' => '',
            'email' => '',
            'nivel_educacion' => '',
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
            'departamento_id' => $departamento->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'nombres' => $parameters['nombres'],
            'apellidos' => $parameters['apellidos'],
            'sexo' => $parameters['sexo'],
            'nacionalidad' => null,
            'estado_civil' => null,
            'fecha_nacimiento' => null,
            'edad' => null,
            'email' => null,
            'nivel_educacion' => null,
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => $parameters['carnet_portuario'],
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $parameters['estado'],
            'fecha_inactividad' => null,
            'gerencia_id' => $parameters['departamento_id'],
        ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearColaboradorConDepartamentoSubarea()
    {
        $colaborador = factory(Colaborador::class)->make();
        $departamento = factory(Departamento::class)->create([
            'tipo' => Departamento::SUBAREA,
        ]);
        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'estado_civil' => $colaborador->estado_civil,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('Y-m-d'),
            'edad' => $colaborador->edad,
            'email' => $colaborador->email,
            'nivel_educacion' => $colaborador->nivel_educacion,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => '',
            'talla_chaleco' => '',
            'talla_polera' => '',
            'talla_pantalon' => '',
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
            'departamento_id' => $departamento->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'nombres' => $parameters['nombres'],
            'apellidos' => $parameters['apellidos'],
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'estado_civil' => $parameters['estado_civil'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => $parameters['edad'],
            'email' => $parameters['email'],
            'nivel_educacion' => $parameters['nivel_educacion'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => $parameters['carnet_portuario'],
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => null,
            'talla_chaleco' => null,
            'talla_polera' => null,
            'talla_pantalon' => null,
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $parameters['estado'],
            'fecha_inactividad' => null,
            'subarea_id' => $parameters['departamento_id'],
        ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarCrearColaborador()
    {
        $colaborador = factory(Colaborador::class)->make();
        $url = '/api/colaboradores';

        $parameters = [
            'rut' => '',
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'estado_civil' => 'Nuevo estado civil',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'edad' => $colaborador->edad,
            'email' => ' el correo del colaborador',
            'nivel_educacion' => $colaborador->nivel_educacion,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => 'LICENCIA B',
            'vencimiento_licencia_b' => 'fecha de vencimiento de licencia b',
            'licencia_d' => 'LICENCIA D',
            'vencimiento_licencia_d' => 'fecha de vencimiento de licencia d',
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'rut',
            'estado_civil',
            'fecha_nacimiento',
            'email',
            'licencia_b',
            'vencimiento_licencia_b',
            'licencia_d',
            'vencimiento_licencia_d',
        ]);

        $parameters = [
            'rut' => '123456789',
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'estado_civil' => $colaborador->estado_civil,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('Y-m-d'),
            'edad' => $colaborador->edad,
            'email' => $colaborador->email,
            'nivel_educacion' => $colaborador->nivel_educacion,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => 'carnet portuario',
            'vencimiento_carnet_portuario' => 'vencimiento carnet portuario',
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => 'fecha de ingreso',
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => 'Estado del colaborador',
            'fecha_inactividad' => 'fecha de inactividad',
            'departamento_id' => '9999',
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'carnet_portuario',
            'vencimiento_carnet_portuario',
            'fecha_ingreso',
            'estado',
            'fecha_inactividad',
            'departamento_id',
        ]);

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'estado_civil' => $colaborador->estado_civil,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('d-m-Y'),
            'edad' => $colaborador->edad,
            'email' => $colaborador->email,
            'nivel_educacion' => $colaborador->nivel_educacion,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('d-m-Y'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('d-m-Y'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('d-m-Y'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('d-m-Y'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'fecha_nacimiento',
            'vencimiento_licencia_b',
            'vencimiento_licencia_d',
            'vencimiento_carnet_portuario',
            'fecha_ingreso',
        ]);
    }

    /**
     * A basic test example.
     */
    public function testValidarRUTAlCrearColaborador()
    {
        $colaborador = factory(Colaborador::class)->make();
        $departamento = factory(Departamento::class)->create([
            'tipo' => Departamento::GERENCIA_GENERAL,
        ]);
        $url = '/api/colaboradores';

        $parameters = [
            'rut' => 'RUT-1234578',
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'nombres' => $colaborador->nombres,
            'apellidos' => $colaborador->apellidos,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => '',
            'estado_civil' => '',
            'fecha_nacimiento' => '',
            'edad' => '',
            'email' => '',
            'nivel_educacion' => '',
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
            'departamento_id' => $departamento->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(409)
                    ->assertSeeText(json_encode('El rut es inválido.'));
    }
}
