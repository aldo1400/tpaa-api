<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeriodoIdAttributeInEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('encuestas', function (Blueprint $table) {
            $table->dropColumn('periodo');
            $table->string('nombre');
            $table->unsignedInteger('periodo_id');
            $table->foreign('periodo_id')->references('id')->on('periodos');
            $table->dropForeign('encuestas_encuesta_plantilla_id_foreign');
            $table->dropColumn('encuesta_plantilla_id');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::table('encuestas', function (Blueprint $table) {
            $table->string('periodo');
            $table->dropColumn('nombre');
            $table->dropForeign('encuestas_periodo_id_foreign');
            $table->dropColumn('periodo_id');

            $table->unsignedInteger('encuesta_plantilla_id');
            $table->foreign('encuesta_plantilla_id')->references('id')->on('encuesta_plantillas');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
