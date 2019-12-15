<?php

namespace Tests\Feature\Colaboradores;

use Tests\TestCase;
use App\Colaborador;

class CrudTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testCrearColaborador()
    {
        $colaborador = factory(Colaborador::class)->make();
        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => $colaborador->password,
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

        // dd($parameters);
        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'password' => $parameters['password'],
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
}
