<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoMovilidadIdAttributeInMovilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movilidades', function (Blueprint $table) {
            $table->unsignedInteger('tipo_movilidad_id');
            $table->foreign('tipo_movilidad_id')->references('id')->on('tipo_movilidades');
            $table->dropColumn('tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movilidades', function (Blueprint $table) {
            $table->dropForeign('movilidades_tipo_movilidad_id_foreign');
            $table->dropColumn('tipo_movilidad_id');
            $table->string('tipo')->default('Nuevo');
        });
    }
}
