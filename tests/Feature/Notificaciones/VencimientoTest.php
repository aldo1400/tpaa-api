<?php

namespace Tests\Feature\Notificaciones;

use Tests\TestCase;
use App\Colaborador;
use App\Notificacion;

class VencimientoTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testVerificarQueSeCreeNotificacionSiSeVenceLasFechaDeLicenciaByD()
    {
        $colaborador = factory(Colaborador::class)->create([
            'vencimiento_licencia_b' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_licencia_d' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_carnet_portuario' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_credencial_vigilante' => now()->addDays(60)->format('Y-m-d'),
        ]);

        $this->artisan('colaboradores:vencimiento');

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_B,
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_D,
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::CARNET,
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::CREDENCIAL,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testVerificarQueSeCreeNotificacionSiSeVenceLasFechaDeLicenciaByDSinFechaCredencialVigilante()
    {
        $colaborador = factory(Colaborador::class)->create([
            'vencimiento_licencia_b' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_licencia_d' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_carnet_portuario' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_credencial_vigilante' => null,
        ]);

        $this->artisan('colaboradores:vencimiento');

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_B,
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_D,
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::CARNET,
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::CREDENCIAL,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testVerificarQueSeCreeNotificacionSiSeVenceLasFechaDeCarnetProtuarioYCredencialVigilante()
    {
        $colaborador = factory(Colaborador::class)->create([
            'vencimiento_licencia_b' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_licencia_d' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_carnet_portuario' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_credencial_vigilante' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $this->artisan('colaboradores:vencimiento');

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_B,
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_D,
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::CARNET,
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::CREDENCIAL,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testVerificarQueNoSeCreenNotificacionSiSeVenceLasFechaDeCarnetProtuarioYCredencialVigilanteMasDeUnaVez()
    {
        $colaborador = factory(Colaborador::class)->create([
            'vencimiento_licencia_b' => now()->addDays(10)->format('Y-m-d'),
            'vencimiento_licencia_d' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_carnet_portuario' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_credencial_vigilante' => now()->addDays(60)->format('Y-m-d'),
        ]);

        $notificacion = factory(Notificacion::class)
                        ->create([
                            'colaborador_id' => $colaborador->id,
                            'tipo' => 'licencia_b',
                            'mensaje' => 'licencia_b',
                        ]);

        $this->artisan('colaboradores:vencimiento');

        $response = $this->get('api/colaboradores/'.$colaborador->id.'/notificaciones');

        $this->assertCount(1, $response->json());

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => Notificacion::LICENCIA_B,
        ]);
    }
}
