<?php

use Illuminate\Database\Migrations\Migration;

class AddNewTypeOfMobilityInTipoMovilidadTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('tipo_movilidades')->insert([
            [
                'tipo' => 'Termino de contrato',
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
        $tipoMovilidades = array('Termino de contrato');
        DB::table('tipo_movilidades')->whereIn('tipo', $tipoMovilidades)->delete();
    }
}
