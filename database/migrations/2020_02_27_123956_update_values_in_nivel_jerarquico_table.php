<?php

use Illuminate\Database\Migrations\Migration;

class UpdateValuesInNivelJerarquicoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('niveles_jerarquico')
            ->where('nivel_nombre', 'Operativo Supervisión')
            ->update(['nivel_nombre' => 'Operativo de Supervisión']);

        DB::table('niveles_jerarquico')
            ->where('nivel_nombre', 'Ejecución')
            ->update(['nivel_nombre' => 'Operativo de Ejecución']);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table('niveles_jerarquico')
        ->where('nivel_nombre', 'Operativo de Supervisión')
        ->update(['nivel_nombre' => 'Operativo Supervisión']);

        DB::table('niveles_jerarquico')
        ->where('nivel_nombre', 'Operativo de Ejecución')
        ->update(['nivel_nombre' => 'Ejecución']);
    }
}
