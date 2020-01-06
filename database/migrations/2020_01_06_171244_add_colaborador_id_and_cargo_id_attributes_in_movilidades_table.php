<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColaboradorIdAndCargoIdAttributesInMovilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movilidades', function (Blueprint $table) {
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->unsignedInteger('cargo_id')->nullable();
            $table->foreign('colaborador_id')->references('id')->on('colaboradores');
            $table->unsignedInteger('colaborador_id')->nullable();
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
            $table->dropForeign('movilidades_cargo_id_foreign');
            $table->dropColumn('cargo_id');
            $table->dropForeign('movilidades_colaborador_id_foreign');
            $table->dropColumn('colaborador_id');
        });
    }
}
