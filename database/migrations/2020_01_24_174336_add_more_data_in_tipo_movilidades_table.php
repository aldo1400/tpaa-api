<?php

use Illuminate\Database\Migrations\Migration;

class AddMoreDataInTipoMovilidadesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('tipo_movilidades')->insert([
            [
                'tipo' => 'Nuevo (a)',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Movilidad',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Desarrollo',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Desvinculado (a)',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Renuncia',
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
        $tipoMovilidades = array('Nuevo (a)', 'Movilidad', 'Desarrollo', 'Desvinculado (a)', 'Renuncia');
        DB::table('tipo_movilidades')->whereIn('tipo', $tipoMovilidades)->delete();
    }
}
