<?php

use Illuminate\Database\Migrations\Migration;

class AddMultipleRegistersInNivelesEducacionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('niveles_educacion')->insert([
            [
                'nivel_tipo' => 'Universitario Completo',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Media Técnico Profesional Completa',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Media Científico-Humanista Completa',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Técnico Nivel Superior o Profesional Completa',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Universitario Incompleto',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Técnico Nivel Superior o Profesional Incompleta',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Media Técnico Profesional Incompleta',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Universidad Pregrado',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Básica Completa',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_tipo' => 'Validación de estudios para Fines laborales',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $nivelesEducacion = array(
                                'Universitario Completo',
                                'Media Técnico Profesional Completa',
                                'Media Científico-Humanista Completa',
                                'Técnico Nivel Superior o Profesional Completa',
                                'Universitario Incompleto',
                                'Técnico Nivel Superior o Profesional Incompleta',
                                'Media Técnico Profesional Incompleta',
                                'Universidad Pregrado',
                                'Básica Completa',
                                'Validación de estudios para Fines laborales',
                            );
        DB::table('niveles_educacion')->whereIn('nivel_tipo', $nivelesEducacion)->delete();
    }
}
